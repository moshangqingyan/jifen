<?php

namespace App\Admin\Repository;
use App\Model\ApiUserCount;
use App\Model\Insurance;

/**
 * Class PremiumCountExport
 * @package App\Admin\Repository
 */
class PremiumCountExport
{
    /**
     * @var \App\Model\ApiUser
     */
    protected $user;

    /**
     * @var string
     */
    protected $startDay;

    /**
     * @var string
     */
    protected $endDay;

    /**
     * PremiumCountExport constructor.
     * @param \App\Model\ApiUser $user
     * @param $startDay
     * @param $endDay
     */
    public function __construct(\App\Model\ApiUser $user, $startDay, $endDay)
    {
        $this->user = $user;
        $this->startDay = $startDay;
        $this->endDay = $endDay;
    }

    /**
     * @return string
     */
    public function csv()
    {
        return $this->buildCsv($this->getData());
    }

    /**
     * @return string
     */
    public function csvName()
    {
        $fileName = $this->user->username;

        $startDay = $this->startDay ? date('n.d', strtotime($this->startDay)) : '';
        $endDay = $this->endDay ? date('n.d', strtotime($this->endDay)) : '';

        if (!empty($startDay)) {
            if (!empty($endDay)) {
                $fileName .= $startDay . '-' . $endDay;
            } else {
                $fileName .= $startDay . '后';
            }
        } else {
            if (!empty($endDay)) {
                $fileName .= $endDay . '前';
            }
        }

        return $fileName . '.csv';
    }

    /**
     * @return \App\Model\ApiUserCount[]|array|\Illuminate\Database\Eloquent\Collection
     */
    protected function getData()
    {
        $query = ApiUserCount::where('user_id', $this->user->id);

        if ($this->startDay) {
            $query->where('date', '>=', $this->startDay);
        }
        if ($this->endDay) {
            $query->where('date', '<=', $this->endDay);
        }
        return $query->get();
    }

    /**
     * @param $originData
     * @return string
     */
    protected function buildCsv($originData)
    {
        $data = $useInsurance = [];
        foreach ($originData as $rows) {
            if (!empty($rows['premium'])) {
                $premiumCount = json_decode($rows['premium'], true);
                $data[$rows['date']] = $premiumCount;

                foreach ($premiumCount as $key => $item) {
                    if (!in_array($key, $useInsurance)) {
                        $useInsurance[] = $key;
                    }
                }
            }
        }

        $output = $this->getTitle($useInsurance);

        foreach ($data as $date => $datum) {
            $count['date'] = $date;
            foreach ($useInsurance as $insurance) {
                $count[$insurance] = isset($datum[$insurance]) ? $datum[$insurance] : 0;
            }
            $count['total'] = array_sum($datum);
            $output .= $this->putcsv($count);
        }

        return $output;
    }

    /**
     * 生成第一行的头信息
     *
     * @param array $useInsurance
     * @return string
     */
    protected function getTitle(array $useInsurance)
    {
        $insurance = Insurance::all()->pluck('name', 'code');

        $title[] = $this->iconvUtf8ToGb2312('日期');
        foreach ($useInsurance as $item) {
            $title[] = $this->iconvUtf8ToGb2312($insurance[$item]);
        }
        $title[] = $this->iconvUtf8ToGb2312('总计');

        return $this->putcsv($title);
    }

    /**
     * @param $string
     * @return string
     */
    protected function iconvUtf8ToGb2312($string)
    {
        return iconv('utf-8', 'gb2312', $string);
    }

    /**
     * @param $row
     * @param string $fd
     * @param string $quot
     * @return string
     */
    protected function putcsv($row, $fd = ',', $quot = '"')
    {
        $str = '';
        foreach ($row as $cell) {
            $cell = str_replace([$quot, "\n"], [$quot . $quot, ''], $cell);
            if (strchr($cell, $fd) !== FALSE || strchr($cell, $quot) !== FALSE) {
                $str .= $quot . $cell . $quot . $fd;
            } else {
                $str .= $cell . $fd;
            }
        }
        return substr($str, 0, -1) . "\n";
    }
}

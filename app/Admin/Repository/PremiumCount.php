<?php

namespace App\Admin\Repository;

use App\Model\ApiUser;
use App\Model\ApiUserCount;
use App\Model\Insurance;
use App\Request;
use Illuminate\Support\Collection;

/**
 * 算价次数统计
 *
 * @package App\Admin\Repository
 */
class PremiumCount
{
    /**
     * 统计用户算价次数(统计出每个算价器的算价次数)的 chart bar数据
     *
     * @param string $startDate
     * @param string $endDate
     * @param int $userId 指定用户ID
     * @return array
     */
    public function getBarDataCountByUser($startDate, $endDate, $userId = null)
    {
        return $this->buildInsuranceBarData(
            $this->getDays($startDate, $endDate),
            $this->getOriginData($startDate, $endDate, $userId)
        );
    }

    /**
     * 统计用户算价总数的 chart line 数据
     *
     * @param string $startDate
     * @param string $endDate
     * @param int $userId 指定用户ID
     * @return array
     */
    public function getLineDataCountByUser($startDate, $endDate, $userId = null)
    {
        return $this->buildLineData(
            $this->getDays($startDate, $endDate),
            $this->getOriginData($startDate, $endDate, $userId)
        );
    }

    /**
     * 统计算价器算价次数(统计出每个用户的算价次数)的 chart bar数据
     *
     * @param string $startDate
     * @param string $endDate
     * @param string $insuranceCode 指定算价器代码
     * @return array
     */
    public function getBarDataCountByInsurance($startDate, $endDate, $insuranceCode = null)
    {
        return $this->buildUserBarData(
            $this->getDays($startDate, $endDate),
            $this->getOriginData($startDate, $endDate, null, $insuranceCode),
            $insuranceCode
        );
    }

    /**
     * 统计算价器算价总数的 chart line 数据
     *
     * @param string $startDate
     * @param string $endDate
     * @param string $insuranceCode 指定算价器代码
     * @return array
     */
    public function getLineDataCountByInsurance($startDate, $endDate, $insuranceCode = null)
    {
        return $this->buildLineData(
            $this->getDays($startDate, $endDate),
            $this->getOriginData($startDate, $endDate, null, $insuranceCode),
            $insuranceCode
        );
    }

    /**
     * 按算价器组装bar需求的数据,（柱状图的主体是算价器）
     *
     * @param array $days 日期
     * @param Collection $originData 原始数据
     * @return array
     */
    protected function buildInsuranceBarData(array $days, Collection $originData)
    {
        /**
         * 数据格式
         * $bar = new \App\Admin\Widgets\Bar([
         *          '2018-01-01', '2018-01-02'
         *     ], [
         * ['四川国寿财', [21, 12]],
         * ['四川新太平洋', [221, 32]],
         * ]);
         */
        // 统计数据中所有使用的算价器
        $userInsurance = [];
        foreach ($originData->toArray() as $datum) {
            if (!is_null($datum['premium'])) {
                $userInsurance = array_unique(array_merge($userInsurance, array_keys($datum['premium'])));
            }
        }

        // 统计每个算价器每天的使用次数
        $insuranceCount = array_fill_keys($userInsurance, array_fill_keys(array_values($days), 0));
        foreach ($originData->toArray() as $datum) {
            if (!is_null($datum['premium'])) {
                foreach ($datum['premium'] as $insuranceCode => $count) {
                    if (isset($insuranceCount[$insuranceCode][$datum['date']])) {
                        $insuranceCount[$insuranceCode][$datum['date']] += $count;
                    } else {
                        $insuranceCount[$insuranceCode][$datum['date']] = $count;
                    }
                }
            }
        }

        $insurances = Insurance::all()->pluck('name', 'code')->toArray();
        $barData = [];
        foreach ($insuranceCount as $insuranceCode => $count) {
            $barData[] = [
                $insurances[$insuranceCode],
                array_values($count)
            ];
        }

        return [
            'labels' => $days,
            'data' => $barData
        ];
    }

    /**
     * 按用户组装bar需求的数据，柱状图的主体是用户
     *
     * @param array $days 日期
     * @param Collection $originData 原始数据
     * @param string $insuranceCode 指定统计的算价器
     * @return array
     */
    protected function buildUserBarData(array $days, Collection $originData, $insuranceCode = null)
    {
        /**
         * 数据格式
         * $bar = new \App\Admin\Widgets\Bar([
         *          '2018-01-01', '2018-01-02'
         *     ], [
         * ['用户A', [21, 12]],
         * ['用户B', [221, 32]],
         * ]);
         */
        // 所有使用用户
        $users = array_unique(array_column($originData->toArray(), 'user_id'));

        $userCount = array_fill_keys($users, array_fill_keys(array_values($days), 0));

        foreach ($originData->toArray() as $datum) {
            if (!is_null($datum['premium'])) {
                foreach ($datum['premium'] as $insuranceCountCode => $count) {
                    if (!empty($insuranceCode) && $insuranceCountCode != $insuranceCode) {
                        continue;
                    }

                    if (isset($userCount[$datum['user_id']][$datum['date']])) {
                        $userCount[$datum['user_id']][$datum['date']] += $count;
                    } else {
                        $userCount[$datum['user_id']][$datum['date']] = $count;
                    }
                }
            }
        }

        $apiUsers = ApiUser::all()->pluck('username', 'id')->toArray();
        $barData = [];

        foreach ($userCount as $userId => $count) {
            if (isset($apiUsers[$userId])) {
                $barData[] = [
                    $apiUsers[$userId],
                    array_values($count)
                ];
            }
        }

        return [
            'labels' => $days,
            'data' => $barData
        ];
    }

    /**
     * 组装line需求的数据，总计数据
     */
    public function buildLineData(array $days, Collection $originData, $insuranceCode = null)
    {
        /**
         * 数据格式
         * $bar = new \App\Admin\Widgets\Line([
         *          '2018-01-01', '2018-01-02'
         *     ], [
         * ['总计', [21,2]],
         * ]);
         */
        $totalCount = array_fill_keys(
            array_values($days),
            0
        );
        foreach ($originData as $item) {
            $day = $item['date'];
            if (!empty($item['premium'])) {
                foreach ($item['premium'] as $insurancePremiumCode => $count) {
                    if (!empty($insuranceCode)) {
                        if ($insurancePremiumCode == $insuranceCode) { // 指定了算价器时只计算指定的算价器
                            $totalCount[$day] += $count;
                        }
                    } else {
                        $totalCount[$day] += $count;
                    }
                }
            }
        }

        return [
            'labels' => $days,
            'data' => [['总计', array_values($totalCount)]]
        ];
    }

    /**
     * 缓存数据
     *
     * @var array
     */
    private $tempData = [];

    /**
     * 获取统计的原始数据
     *
     * @param string $startDate
     * @param string $endDate
     * @param null $userId
     * @param null $insuranceCode
     * @return \Illuminate\Support\Collection
     */
    public function getOriginData($startDate, $endDate, $userId = null, $insuranceCode = null)
    {
        $tempKey = md5($startDate . $endDate . $userId . $insuranceCode);
        if (array_key_exists($tempKey, $this->tempData)) {
            return $this->tempData[$tempKey];
        }

        $model = ApiUserCount::where([
            ['date', '>=', $startDate],
            ['date', '<=', $endDate]
        ]);

        if (!is_null($userId)) {
            $model = is_array($userId) ? $model->whereIn('user_id', $userId) : $model->where('user_id', '=', $userId);
        }
        $insuranceCode = \Illuminate\Support\Facades\Request::get('insurance');
        if ($insuranceCode) {
            $model = $model->where(function ($query) use ($insuranceCode) {
                $query->orWhere('premium', 'like', "%$insuranceCode%");
            });
        }

        if ($province = \Illuminate\Support\Facades\Request::input('province')) {
            $model = $model->whereHas('user', function ($query) use ($province) {
                $query->where('province', '=', $province);
            });
        }

        $data = $model->get(['premium', 'date', 'user_id'])->each(function (&$item) {
            $item['premium'] = json_decode($item['premium'], true);
        });

        $this->tempData[$tempKey] = $data;
        return $data;
    }

    /**
     * 获取从某天开始到某天结束的连续每一天日期的数组
     *
     * @param $startDate
     * @param $endDate
     * @return array
     */
    public function getDays($startDate, $endDate)
    {
        $startDateTime = new \DateTime($startDate);
        $endDateTime = new \DateTime($endDate);

        $days = $startDateTime->diff($endDateTime)->days;

        $interval = new \DateInterval('P1D');

        if ($startDateTime < $endDateTime) {
            $preiod = new \DatePeriod($startDateTime, $interval, $days);
        } else {
            $preiod = new \DatePeriod($endDateTime, $interval, $days);
        }

        $dates = [];
        foreach ($preiod as $date) {
            $dates[] = $date->format('Y-m-d');
        }

        return $dates;
    }
}

<section class="content-header">
        <h1>算价器账号</h1>
</section>

<section class="content">
        <div class="box">
                <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                                <tr>
                                        <th>账号</th>
                                        <th>算价器</th>
                                        <th>类型</th>
                                </tr>
                                @foreach($accounts as $row)
                                        <tr>
                                                <td>
                                                        <a href="/account/{!! $row->id !!}">
                                                                {!! array_get(json_decode($row->account, true), 'param1.value') !!}
                                                        </a>
                                                </td>
                                                <td>{!! $row->insurance->name !!}</td>
                                                <td>提交账号</td>
                                        </tr>
                                @endforeach

                                @foreach($allotAccounts as $row)
                                        <tr>
                                                <td>
                                                        <a href="/account/{!! $row->id !!}">
                                                                {!! array_get(json_decode($row->account, true), 'param1.value') !!}
                                                        </a>
                                                </td>
                                                <td>{!! $row->insurance->name !!}</td>
                                                <td>分配账号</td>
                                        </tr>
                                @endforeach

                        </table>
                </div>
        </div>
</section>
<section class="content-header">
        <h1>最近10条使用记录(共{!! $count ?? 0 !!}条使用记录)</h1>
</section>

<section class="content">
        <div class="box">
                <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                                <tr>
                                        <th>用户</th>
                                        <th>时间</th>
                                        <th>结果</th>
                                </tr>
                                @foreach($logs as $row)
                                        <tr>
                                                <td>
                                                        @if($row->user)
                                                        <a href="/apiuser/{!! $row->user->id !!}">
                                                                {!! $row->user->username !!}
                                                        </a>
                                                        @else
                                                        <a href="javascript::void">
                                                                用户不存在
                                                        </a>
                                                        @endif
                                                </td>
                                                <td>{!! $row->created_at !!}</td>
                                                <td>{!! json_decode($row->remark, true)['describe'] !!}</td>
                                        </tr>
                                @endforeach
                        </table>
                </div>
        </div>
</section>
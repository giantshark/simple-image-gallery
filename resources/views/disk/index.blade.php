@extends('layouts.app')
@section('custom-styles')
    <style>
        .number-bet-click {
            color: #fff !important;
            background-color: #c9302c !important;
            border-color: #ac2925 !important;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading"><strong>Disk Usage Overview</strong></div>
                    <div class="panel-body">
                        <div class="col-md-2">
                            Total Size:
                        </div>
                        <div class="col-md-10">
                            {{ $diskUsageOverviewMb }} MB({{ $diskUsageOverviewKb }}B)
                        </div>
                        <br>
                        <div class="col-md-2">
                            No of files:
                        </div>
                        <div class="col-md-10">
                            {{ $totalFile }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading"><strong>Disk Usage Compositions</strong></div>

                    <div class="panel-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Type</th>
                                <th>No of files</th>
                                <th>Size</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($totalFiles as $files)
                                @foreach ($files as $file)
                                    <tr>
                                        <td>{{ $file->mime_type }}</td>
                                        <td>{{ $file->total }}</td>
                                        <td>{{ number_format($file->size/1024, 2) }}MB ({{ $file->size }}B)</td>
                                    </tr>
                                @endforeach
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

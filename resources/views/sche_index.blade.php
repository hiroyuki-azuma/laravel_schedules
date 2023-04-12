@extends('app')
  
@section('content')

    <div class="w-75">
        <div>
        <h3 style="font-size:1.45rem;">{{$yyyy}}年{{$mm}}月は、{{$days}}日まであります。</h3>
        <a href="{{ url('./schedules/') }}?page={{$page-1}}" class="btn btn-sm btn-secondary">前の月</a>
        <a href="{{ url('./schedules/') }}?page=0" class="btn btn-sm btn-secondary">今月</a>
        <a href="{{ url('./schedules/') }}?page={{$page+1}}" class="btn btn-sm btn-secondary">次の月</a>
        </div>
        @php
        foreach($schedules as $schedule){
            //echo $schedule->yyyymmdd;
            //echo $schedule->title;
            //echo $schedule->user_id;
            //echo "<BR>";
            for ($i = 1; $i <= 31; $i++){
                if ($i < 10) { $i = '0' . $i; }
                if ( substr($schedule->yyyymmdd,8,2) == $i ){
                    if(isset($title[$i])){
                        $title[$i].="<div>".$schedule->title."</div>";
                    }else{
                        $title[$i] ="<div>".$schedule->title."</div>";
                    }
                    $title[$i].="<div class='text-end'>";
                    $title[$i].="<span>by ".$schedule->user->name."　</span>";
                    $title[$i].="<span><a href='".route('schedule.edit',[ $schedule->id, 'page' => request()->input('page') ])."'>編集</a></span>";
                    $title[$i].="</div>";
                }
            }
        }
        @endphp

    </div>

    
    @if ($message = Session::get('success'))
            <div class="alert alert-success w-75">
                <p>{{ $message }}</p>
            </div>
    @endif

    <table class="table w-75">
    @for ($i = 1; $i <= $days; $i++)  
        <tr>
            <td style="width: 25%;">  
                @php
                    if ($i < 10) {
                        $i = '0' . $i;
                    }
                @endphp
                <div class="
                @if(date('D', strtotime($yyyy.$mm.$i))=='Sun') 
                    text-danger
                @elseif(date('D', strtotime($yyyy.$mm.$i))=='Sat') 
                    text-primary
                @endif
                ">
                {{$yyyy}}/{{$mm}}/{{ $i }}
                {{date('D', strtotime($yyyy.$mm.$i))}}
                </div>
            </td>
            <td style="width: 65%;">
                @php
                if(isset($title[$i])){
                    echo $title[$i];
                }
                @endphp
            </td>
            <td>
            <a class="btn btn-sm btn-primary" 
                    href="{{ route('schedule.create',['dd' => $i, 'page' => request()->input('page')]) }}">
            登録</a>
            </td>
        </tr>
    @endfor
    </table>
    
    @endsection
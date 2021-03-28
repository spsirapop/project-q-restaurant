@php
    use Haruncpi\LaravelIdGenerator\IdGenerator;

@endphp


<x-admin-layout>


@php
    $namefirst="";
    $id_userfirst=0;
    $i=1;
    $userlogin= Auth::user()->id;
@endphp
@foreach($queues as $row)
    @php
        if($i == 1){
            $namefirst=$row->id_q;
            $id_userfirst=$row->user_id;
        }
        $i++;                                
     @endphp
@endforeach
    <x-slot name="header">


        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" />
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Q-Restaurant
            @if($userlogin == $id_userfirst)
            <b class="float-end">ถึงคิวของคุณเเล้ว</b>
            <b class="float-mid"> จำนวนคิวทั้งหมด <span>{{count($queueAll)}} </span> คน</b>               
            @else
            <b class="float-end"> ตอนนี้ถึงหมายเลขคิวที่ <span>{{$namefirst}} </span></b>
            <b class="float-mid"> จำนวนคิวทั้งหมด <span>{{count($queueAll)}} </span> คน</b>
            @endif
            
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    @if(session("success"))
                        <div class="alert alert-success">{{session('success')}}</div>
                    @endif
                    <div class="card">
                        <div class="card-header">ตารางคิว</div>
                        <table class="table ">
                        <thead class="table-dark">
                            <tr>
                            <th scope="col">ลำดับ</th>
                            <th scope="col">Q-id</th>
                            <th scope="col">ชื่อ</th>
                            <th scope="col">เบอร์</th>
                            <th scope="col">user_id</th>
                            <th scope="col">เวลา</th>
                            <th scope="col">Edit</th>
                            <th scope="col">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $namefirst="";
                                $i=1;
                            @endphp
                            @foreach($queues as $row)
                            @php
                                if($i == 1)
                                $namefirst=$row->id_q;
                                $i++;                                
                            @endphp
                            <tr>
                                <th>{{$queues->firstItem()+$loop->index}}</th>
                                <td>{{$row->id_q}}</td>
                                <td>{{$row->name_q}}</td>
                                <td>{{$row->phone}}</td>
                                <td>{{$row->user_id}}</td>
                                <td>{{$row->created_at->diffForHumans()}}</td>
                                <td>
                                    <a href="{{url('/queue/edit/'.$row->id)}}" class="btn btn-primary"
                                        onclick="return confirm('คุณต้องการเเก้ไขข้อมูลนี้ถาวรหรือไม่ ?')">เเก้ไข</a>
                                </td>
                                <td>
                                    <a href="{{url('/queue/softdelete/'.$row->id)}}" class="btn btn-warning"
                                        onclick="return confirm('คุณต้องการลบข้อมูลนี้หรือไม่ เเต่เหมือนคุณลบเเล้วสามารถกู้กลับคืนได้')">ลบข้อมูล</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$queues->Links()}}
                    </div>


                    <div class="card my-2">
                    <div class="card-header">ถังขยะคิว</div>
                        <table class="table ">
                        <thead class="table-dark" >
                            <tr>
                            <th scope="col">ลำดับ</th>
                            <th scope="col">Q-id</th>
                            <th scope="col">ชื่อ</th>
                            <th scope="col">ลบเมื่อ</th>
                            <th scope="col">กู้คืนข้อมูล</th>
                            <th scope="col">ลบข้อมูลถาวร</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($trashQueues as $row)
                            <tr>
                                <th>{{$trashQueues ->firstItem()+$loop->index}}</th>
                                <td>{{$row->id_q}}</td>
                                <td>{{$row->name_q}}</td>
                                <td>
                                    @if($row->created_at == NULL)
                                         ไม่ถูกนิยาม
                                    @else 
                                        {{Carbon\Carbon::parse($row->created_at)->diffForHumans()}}
                                    @endif
                                </td>
                                <td>
                                    <a href="{{url('/queue/restore/'.$row->id)}}" class="btn btn-primary"
                                        onclick="return confirm('คุณต้องการกู้ข้อมูลนี้หรือไม่ ?')">กู้คืนข้อมูล</a>
                                </td>
                                <td>
                                    <a href="{{url('/queue/delete/'.$row->id)}}" class="btn btn-danger"
                                        onclick="return confirm('คุณต้องการลบข้อมูลนี้ถาวรหรือไม่ ?')" >ลบข้อมูลถาวร</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$trashQueues->Links()}}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">แบบฟอร์มการจองคิว</div>
                        <div class="card-body">
                            <form action="{{route('addQueue')}}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="name_q">ชื่อ</label>
                                    <input type="text" class="form-control" name="name_q">
                                </div>
                                @error('name_q')
                                    <div class="my-2">
                                        <span class="text-danger">{{$message}}</span>
                                    </div>
                                @enderror
                                
                                <div class="form-group">
                                    <label for="phone">เบอร์โทร</label>
                                    <input type="text" class="form-control" name="phone">
                                </div>
                                @error('phone')
                                    <div class="my-2">
                                        <span class="text-danger">{{$message}}</span>
                                    </div>
                                @enderror

                                @php
                                    $id = IdGenerator::generate(['table' => 'queues','field'=>'id_q' ,'length' => 8, 'prefix' =>'Q-']);
                                @endphp

                                <div class="form-group">
                                <label for="id_q">Q-id</label>
                                <input type="text" class="form-control" value="{{$id}}" name="id_q" readonly >
                                </div>
                                    @error('id_q')
                                    <div class="my-2">
                                    <span class="text-danger">{{$message}}</span>
                                    </div>
                                    @enderror
                                <br>
                                <input type="hidden"  name="user_id" value="{{auth::user()->id}}">    
                                    @error('user_id')
                                    <div class="my-2">
                                    <span class="text-danger">{{$message}}</span>
                                    </div>
                                    @enderror
                                <input type="submit" value="บันทึก" class="btn btn-primary"onclick=" return confirm('ต้องการจองคิวด้วยข้อมูลนี้หรือไม่ ?')">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="py-12">
        <div class="container">
                <table class="table">
                    <div class="col-md-4">
                        @if ($message = Session::get('info'))
                                <div class="alert alert-info alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>    
                                <strong>{{ $message }}</strong>
                                </div>
                                @endif
                        <div class="card">
                            <div class="card-header">กรุณาป้อน Q-Id ของท่าน</div>
                            <div class="card-body">
                                <form action="{{route('search')}}" method="post">
                                    @csrf
                                    
                                    <div class="form-group">
                                        <label for="id_q">Q-id</label>
                                        <input type="text" class="form-control" name="id_q">
                                    </div>    
                                    <br>
                                    <input type="submit" value="เช็คคิว" class="btn btn-primary">
                                </form>
                            </div>
                        </div>
                    </div>
                  </table>           
            </div>
        </div>
    </div>
</x-admin-layout>
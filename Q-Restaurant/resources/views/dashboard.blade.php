@php
    use Haruncpi\LaravelIdGenerator\IdGenerator;
@endphp

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
<x-app-layout>
    <x-slot name="header">
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
                        <div class="card-header">ตารางข้อมูลคิว</div>
                        <table class="table ">
                        <thead class="table-dark">
                            <tr>
                            <th scope="col">ลำดับ</th>
                            <th scope="col">Q-id</th>
                            <th scope="col">ชื่อ</th>
                            <th scope="col">เวลาจอง</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                        @php
                            $i=1;
                        @endphp
                        @foreach($queues as $row)
                        <tr>
                            <th>{{$queues->firstItem()+$loop->index}}</th>
                            <td>{{$row->id_q}}</td>
                            <td>{{$row->name_q}}</td>
                            
                            <td>{{$row->created_at->diffForHumans()}}</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{$queues->Links()}}              
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
                                    <input type="text"  class="form-control" name="name_q">
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
                                <input type="submit" value="บันทึก" class="btn btn-primary">
                            </form>
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
    </div>  
</x-app-layout>
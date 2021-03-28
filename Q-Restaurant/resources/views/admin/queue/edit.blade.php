@php
    use Haruncpi\LaravelIdGenerator\IdGenerator;

@endphp


<x-admin-layout>
    <x-slot name="header">

        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Q-Restaurant 
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">แบบฟอร์มแก้ไขข้อมูล</div>
                        <div class="card-body">
                            <form action="{{url('/queue/update/'.$queue->id)}}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="name_q">ชื่อ</label>
                                    <input type="text" class="form-control" name="name_q" value="{{$queue->name_q}}">
                                </div>
                                @error('name_q')
                                    <div class="my-2">
                                        <span class="text-danger">{{$message}}</span>
                                    </div>
                                @enderror

                                <div class="form-group">
                                    <label for="phone">เบอร์โทร</label>
                                    <input type="text" class="form-control" name="phone" value="{{$queue->phone}}">
                                </div>
                                @error('phone')
                                    <div class="my-2">
                                        <span class="text-danger">{{$message}}</span>
                                    </div>
                                @enderror
                                <br>
                                <input type="submit" value="อัพเดต" class="btn btn-primary" onclick=" return confirm('ต้องการอัพเดทด้วยข้อมูลนี้หรือไม่ ?')>
                            </form>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>

</x-admin-layout>
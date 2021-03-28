<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Q-Restaurant   
            <b class="float-end"> USER ในระบบ จำนวน <span>{{count($users)}} </span>คน</b>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <table class="table">
                    <div class = "row">
                    <thead class = "table-dark" >
                      <tr>
                        <th scope="col">ลำดับ</th>
                        <th scope="col">ชื่อ</th>
                        <th scope="col">อีเมลล์</th>
                        <th scope="col">สถานะ</th>
                        <th scope="col">เวลาเข้าระบบ</th>
                      </tr>
                    </thead>
                    <tbody>
                        @php($i=1)
                    @foreach ($users as $row) 
                      <tr>
                        <th >{{$i++}}</th>
                        <td>{{$row->name}}</td>
                        <td>{{$row->email}}</td>
                        <td>{{$row->utype}}</td>
                        <td>{{$row->created_at->diffForHumans()}}</td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
            </div>
            </div>
        </div>
    </div>

</x-admin-layout>

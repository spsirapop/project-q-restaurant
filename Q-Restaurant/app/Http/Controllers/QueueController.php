<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Queue;

use Illuminate\Http\Request;

class QueueController extends Controller
{
    public function index(){
        $queues = Queue::paginate(5);
        $queueAll=Queue::all();
        $trashQueues = Queue::onlyTrashed()->paginate(3);
        return view('admin.queue.index',compact('queues','queueAll','trashQueues'));
    }

    public function indexUser(){
        $queues = Queue::paginate(5);
        $queueAll= Queue::all();
        return view('dashboard',compact('queues','queueAll'));
    }
    public function store(Request $request){
        $request->validate(
            [
                'name_q'=>'required|max:255',
                'phone'=>'required|unique:queues|max:10',
                'id_q'=>'required|unique:queues|max:10',
                'user_id'=>'unique:queues',
            ],
            [
                'name_q.required'=>"กรุณาป้อนชื่อด้วยครับ",
                'name_q.max' => "ห้ามป้อนเกิน 255 ตัวอักษร",

                'phone.required'=>"กรุณาป้อนเบอร์ด้วยครับ",
                'phone.max' => "ห้ามป้อนเกิน 10",
                'phone.unique'=>"มีเบอร์ซ้ำ",

                'id_q.unique'=>"มี Q-idแล้ว กรุณารีเฟรสหน้าจอใหม่",

                'user_id.unique'=>'ท่านเคยจองคิวไปเเล้ว'
            ]
        );
        //บันทึกข้อมูล
        $queue = new Queue;
        $queue->name_q = $request ->name_q;
        $queue->phone = $request ->phone;
        $queue->id_q= $request ->id_q;
        $queue->user_id= Auth::user()->id;
        $queue->save();
       
        return redirect()->back()->with('success',"บันทึกข้อมูลเรียบร้อย");
    }
    public function softdelete($id){

        $delete = Queue::find($id)->delete();
        return redirect()->back()->with('success',"ลบข้อมูลเรียบร้อย");
    }
    public function edit($id){
        $queue= Queue::find($id);

        return view('admin.queue.edit',compact('queue'));
    }
    public function search(Request $request){
        $request->validate(
            [
                'id_q'=>'required|max:10',
            ],
            [
                'id_q.required'=>"กรุณาป้อนชื่อด้วยครับ",
                'id_q.max' => "ห้ามป้อนเกิน 10 ตัวอักษร",

            ]
        );
        $queueAll=Queue::all();
        $id = $request->id_q;
        $countid=0;
        $status = 0;
        foreach($queueAll as $row){
            $countid++;
            if($row->id_q === $id){
                break;
            }
            elseif($countid == count($queueAll)){
                $status=1;
            }
        }
        $queuebefore = $countid -1;


        if($status == 1 ){
            return redirect()->back()->with('info',"ไม่พบคิวที่ท่านกรอก ");
        }
        if($queuebefore == 0){
            return redirect()->back()->with('info',"ถึงคิวของคุณเเล้ว ");
        }
        else
            return redirect()->back()->with('info',"เหลืออีก $queuebefore จะถึงคิวของคุณ , คิวของคุณคือลำดับที่ $countid ");
    }

    public function update(Request $request , $id){
        //ตรวจสอบข้อมูล
       $request->validate(
            [
                'name_q'=>'required|max:255',
                'phone'=>'required|unique:queues|max:10',

            ],
            [
                'name_q.required'=>"กรุณาป้อนชื่อด้วยครับ",
                'name_q.max' => "ห้ามป้อนเกิน 255 ตัวอักษร",

                'phone.required'=>"กรุณาป้อนเบอร์ด้วยครับ",
                'phone.max' => "ห้ามป้อนเกิน 10",
                'phone.unique'=>"มีเบอร์ซ้ำ",
            ]
        );
        $update = Queue::find($id)->update([
            'name_q'=>$request->name_q,
            'phone'=>$request->phone

        ]);
        
        return redirect()->route('queue')->with('success',"อัพเดตข้อมูลเรียบร้อย");
    }
    public function restore($id){
        $restore=Queue::withTrashed()->find($id)->restore();
        return redirect()->back()->with('success',"กู้คืนข้อมูลเรียบร้อย");
    }

    public function delete($id){
        $delete=Queue::onlyTrashed()->find($id)->forceDelete();
        return redirect()->back()->with('success',"ลบข้อมูลถาวรเรียบร้อย");
}



}

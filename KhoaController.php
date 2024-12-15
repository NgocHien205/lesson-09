<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KhoaController extends Controller
{
    //bảng khoa
    public function khoaIndex()
    {
        $khoas = DB::select('select * from khoa');
        return view('khoa.khoaIndex',['khoas'=>$khoas]);
    }

    //chi tiết : detail
    public function detail($makh)
    {
        $khoa = DB::select('select * from khoa where MaKH =?',[$makh])[0];
        return view('khoa.detail',['khoa'=>$khoa]);
    }

    // Edit Form :sửa
    public function edit($makh)
    {
        $khoa = DB::select('select * from khoa where MaKH =?',[$makh])[0];
        return view('khoa.edit',['khoa'=>$khoa]);
    }
    // Edit Submit : sửa
    public function editSubmit( Request $request)
    {
        $makh=$request->input('MaKH');
        $tenkh=$request->input('TenKH');
        DB::update("update khoa set TenKH = ? where MaKH = ?",[$tenkh,$makh]);
        return redirect('/khoas');
    }

    // insert Form :sửa
    public function insert()
    {
        return view('khoa.insert');
    }
  // insert Submit : sửa
    public function insertSubmit(Request $request)
    {
        $khoa = $request->validate([
            'MaKH'=>'required|max=50',
            'TenKH'=>'required|max=50'
        ],
        [
            'MaKH.required' => 'Vui lòng nhập mã Khoa.',
            'MaKH.max' => 'Mã khoa tối đa 5 ký tự.',
            'TenKH.required' =>  'Vui lòng nhập tên Khoa.',
            'MaKH.max' => 'Tên khoa tối đa 50 ký tự.',
        ]
    );
        $makh=$request->input('MaKH');
        $tenkh=$request->input('TenKH');
        DB::insert("insert into khoa(MaKH,TenKH) values (?,?) ",[$makh,$tenkh]);
        return redirect('/khoas');
    }
}
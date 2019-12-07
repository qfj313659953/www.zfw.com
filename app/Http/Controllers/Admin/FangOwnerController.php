<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\FangOwnerRequest;
use App\Jobs\FangOwnerExcelJob;
use App\Model\FangOwner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
#引入导出的excel类
use Maatwebsite\Excel\Facades\Excel;
#引入导出数据类
use App\Exports\FangOwnerExport;

class FangOwnerController extends BaseController
{

    /**列表页
     */
    public function index()
    {
        $data = FangOwner::paginate($this->pagesize);
        $zip = new \ZipArchive();
        if ($zip->open('test_dir.zip',\ZIPARCHIVE::CREATE) !== TRUE) {
            die ("Could not open archive");
        }

        $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator("./uploads/fangownerexcel/"));

        foreach ($iterator as $key => $value) {
            try {

                $zip->addFile(realpath($key),$key);
                echo "'$key' successfully added.\n";
            } catch (\Exception $e) {
                echo "ERROR: Could not add the file '$key': $e\n";
            }
        }

        $zip->close();

        $excelpath = public_path('/uploads/fangownerexcel/fangowner.zip');
        if(file_exists($excelpath)){
            $isshow = true;
        }else{
            $isshow = false;
        }
        $addBtn = FangOwner::addBtn('admin.fangOwner.create','房东');
        return view('admin.fangOwner.index',compact('data','addBtn','excelpath','isshow'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.fangOwner.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FangOwnerRequest $request)
    {
        $data = $request->except(['_token','file']);
        FangOwner::create($data);
        return redirect(route('admin.fangOwner.index'))->with('success','添加房东成功');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\FangOwner  $fangOwner
     * @return \Illuminate\Http\Response
     */
    public function show(FangOwner $fangOwner)
    {
        $pics = $fangOwner->pic;
        $arr = explode('#',$pics);
        //判断是否存在图片
        if(count($arr) <= 1){
            return ['status'=>1,'msg'=>'图片不存在','data'=>[]];
        }
        array_shift($arr);
        return ['status' => 0,'msg' => '成功','data'=>$arr];
    }

    public function export()
    {
        #导出并保存到服务器指定的磁盘中,参数3为文件保存的节点名称
        $all = FangOwner::paginate(5)->toArray();
        $num = $all['last_page'];
        $zips = [];
        for($i = 1;$i<=$num;$i++){
            $offset = ($i - 1) * 5;
            $this->dispatch(new FangOwnerExcelJob($offset,$i));
            array_push($zips,public_path('/uploads/fangownerexcel/fangowner'.$i.'.xlsx'));
           // array_push($zips,'fangowner'.$i.'.xlsx');
        }
        /*$zipName = public_path('/uploads/fangownerexcel/fangowner.zip');
        if(!file_exists($zipName)){
            $zip = new \ZipArchive();
            if($zip->open('fangowner.zip',\ZipArchive::CREATE === TRUE)){
                //dd($zips[0]);
                //将文件添加到zip文件中
                $zip->addFile('/uploads/fangownerexcel/fangowner1.xlsx');
                //关闭zip文件
                $zip->close();
                /*array_map(function($val) use($zip) {
                    if(file_exists($val)){
                        //将文件添加到zip文件中
                        $zip->addFile($val);
                        //关闭zip文件
                        $zip->close();
                    }
                },$zips);
            }
        }*/




        return redirect(route('admin.fangOwner.index'));




    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\FangOwner  $fangOwner
     * @return \Illuminate\Http\Response
     */
    public function edit(FangOwner $fangOwner)
    {
        //dd($fangOwner);
        return view('admin.fangOwner.edit',compact('fangOwner'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\FangOwner  $fangOwner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FangOwner $fangOwner)
    {
        $fangOwner->update($request->except(['_token','_method','file']));
        return redirect(route('admin.fangOwner.index'))->with('success','房东修改成功');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\FangOwner  $fangOwner
     * @return \Illuminate\Http\Response
     */
    public function destroy(FangOwner $fangOwner)
    {
        $fangOwner->delete();
        return ['status' => 0,'msg' => '房东信息删除成功'];
    }




    function addFileToZip($path, $zip) {
        $handler = opendir($path); //打开当前文件夹由$path指定。
        /*
        循环的读取文件夹下的所有文件和文件夹
        其中$filename = readdir($handler)是每次循环的时候将读取的文件名赋值给$filename，
        为了不陷于死循环，所以还要让$filename !== false。
        一定要用!==，因为如果某个文件名如果叫'0'，或者某些被系统认为是代表false，用!=就会停止循环
        */
        while (($filename = readdir($handler)) !== false) {
            if ($filename != "." && $filename != "..") {//文件夹文件名字为'.'和‘..’，不要对他们进行操作
                if (is_dir($path . "/" . $filename)) {// 如果读取的某个对象是文件夹，则递归
                    addFileToZip($path . "/" . $filename, $zip);
                } else { //将文件加入zip对象
                    $zip->addFile($path . "/" . $filename);
                }
            }
        }
        @closedir($path);
    }
    public function zipexcel()
    {
        $zip = new \ZipArchive();
        if ($zip->open('images.zip', \ZipArchive::OVERWRITE) === TRUE) {
            $this->addFileToZip(public_path('/uploads/fangownerexcel'), $zip); //调用方法，对要打包的根目录进行操作，并将ZipArchive的对象传递给方法
            $zip->close(); //关闭处理的zip文件
        }

    }
}

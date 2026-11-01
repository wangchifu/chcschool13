@extends('layouts.master')

@section('nav_open_files_active', 'active')
<?php $openfile_name = (empty($setup->openfile_name))?"檔案庫":$setup->openfile_name; ?>
@section('title', $openfile_name.' | ')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-11">
            <h1 class="h2 mb-3">
                @if(empty($setup->openfile_name))
                    檔案庫
                @else
                    {{ $setup->openfile_name }}
                @endif
            </h1>
            <?php
            $final = end($folder_path);
            $final_key = key($folder_path);
            $p="";
            $f="app/public/".$school_code."/open_files";
            $last_folder = "";
            ?>
            
            <!-- 無障礙 HM1010301C 修正：麵包屑導覽區塊 -->
            <nav aria-label="目前的檔案目錄路徑" class="mb-3">
                <span>路徑：</span>
                @auth
                    <?php
                        $check_exec = \App\Models\UserGroup::where('user_id',auth()->user()->id)
                        ->where('group_id',1)
                        ->first();                                                          
                    ?>
                @endauth            
                @foreach ($folder_path as $k => $v)
                    <?php
                    if($k=="0"){
                        $k = null;

                    }else{
                        $p .= '&'.$k;
                        $f .=  '/'.$v;
                    }
                    if($k != $final_key and !empty($k)){
                        $last_folder .= '&'.$k;
                    }

                    ?>
                    @if($v == $final)
                        <i class="fa fa-folder-open text-warning" aria-hidden="true"></i> 
                        <a href="{{ route('open_files.index',$p) }}" aria-current="page">{{$v}}</a> /
                    @else
                        <i class="fa fa-folder text-warning" aria-hidden="true"></i> 
                        <a href="{{ route('open_files.index',$p) }}">{{$v}}</a> /
                    @endif
                @endforeach
            </nav>

            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0" style="word-break:break-all;" aria-label="檔案與目錄列表">
                    <caption class="visually-hidden">檔案庫目錄與檔案清單列表</caption>
                    <thead class="table-light">
                    <tr>
                        <th scope="col">目錄 / 檔案名稱</th>
                        <th scope="col">類型</th>
                        <th scope="col">數量 / 大小</th>
                        <th scope="col">建立者</th>
                        <th scope="col">建立時間</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($path!=null)
                        <tr>
                            <td scope="row">
                                <i class="fas fa-arrow-circle-left" aria-hidden="true"></i> 
                                <a href="{{ route('open_files.index',$last_folder) }}" aria-label="返回上一層目錄">上一層</a>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endif
                    @foreach ($folders as $folder)
                        <?php
                        $folder_p = $path.'&'.$folder->id;
                        ?>
                        <tr>
                            <td scope="row">
                                <i class="fas fa-folder text-warning" aria-hidden="true"></i> 
                                <a href="{{ route('open_files.index',$folder_p) }}">{{ $folder->name }}</a>
                            </td>
                            <td>
                                <?php 
                                    $n = \App\Models\Upload::where('folder_id',$folder->id)->count();                                                                
                                ?>
                                <strong>目錄</strong>
                                @auth                            
                                @if(($folder->user_id == auth()->user()->id and !empty($check_exec)) or ($folder->job_title == auth()->user()->title and !empty($check_exec)) or auth()->user()->admin==1)
                                        <!-- 無障礙 HM1020401C 修正：改用 button 元素開窗 -->
                                        <a href="{{ route('open_files.edit',[$folder->id,$folder_p]) }}" class="btn btn-link p-0 text-primary venobox" data-vbtype="iframe" aria-label="編輯目錄：{{ $folder->name }}">
                                            <i class='fas fa-edit' aria-hidden="true"></i>
                                        </a>
                                    @if($n == 0)
                                        <a href="#!" id="delete_folder{{ $folder->id }}" onclick="sw_confirm1('確定刪除目錄嗎？','{{ route('open_files.delete',$folder_p) }}')" aria-label="刪除目錄：{{ $folder->name }}">
                                            <i class="fas fa-minus-square text-danger" aria-hidden="true"></i>
                                        </a>
                                    @endif
                                @endif
                                @endauth
                            </td>
                            <td>
                                {{ $n }} 個項目
                            </td>
                            <td>
                                @if(!empty($folder->job_title))
                                    {{ $folder->job_title }}
                                @else
                                    @if($folder->user->name == "系統管理員")
                                        系統管理員
                                    @else
                                        {{ $folder->user->title }}
                                    @endif
                                @endif                            
                            </td>
                            <td>
                                @if(file_exists(storage_path($f.'/'.$folder->name)))
                                    {{ date ("Y-m-d H:i:s",filemtime(storage_path($f.'/'.$folder->name))) }}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    @foreach ($files as $file)
                        <?php
                        $file_p = $path.'&'.$file->id;
                        ?>
                        <tr>
                            <td scope="row">
                                @if(file_exists(storage_path($f.'/'.$file->name)))
                                    <?php $f2 = str_replace('app/public','',$f); ?>
                                    <i class="fas fa-file text-info" aria-hidden="true"></i> 
                                    <!-- 無障礙 HM1200101C 修正：另開新視窗補充提示訊息 -->
                                    <a href="{{ asset('storage'.$f2.'/'.$file->name) }}" target="_blank" rel="noopener noreferrer" aria-label="開啟/下載檔案：{{ $file->name }} (另開新視窗)">
                                        {{ $file->name }}
                                    </a>
                                    <span class="visually-hidden">(另開新視窗)</span>
                                @else
                                    <span class="text-danger">
                                        <i class="fas fa-file" aria-hidden="true"></i> {{ $file->name }} (檔案已遺失)
                                    </span>
                                @endif
                            </td>
                            <td>
                                檔案
                                @auth
                                    @if(($file->user_id == auth()->user()->id and !empty($check_exec)) or ($file->job_title == auth()->user()->title and !empty($check_exec)) or auth()->user()->admin==1)
                                        <a href="{{ route('open_files.edit',[$file->id,$file_p]) }}" class="btn btn-link p-0 text-primary venobox" data-vbtype="iframe" aria-label="編輯檔案：{{ $file->name }}">
                                            <i class='fas fa-edit' aria-hidden="true"></i>
                                        </a>
                                        <a href="#!" id="delete_file{{ $file->id }}" onclick="sw_confirm1('確定刪除？','{{ route('open_files.delete',$file_p) }}')" aria-label="刪除檔案：{{ $file->name }}">
                                            <i class="fas fa-minus-square text-danger" aria-hidden="true"></i>
                                        </a>
                                    @endif
                                @endauth
                            </td>
                            <td>
                                @if(file_exists(storage_path($f.'/'.$file->name)))
                                    {{ filesizekb(storage_path($f.'/'.$file->name)) }} KB
                                @else
                                    <small class="text-danger">已遺失</small>
                                @endif
                            </td>
                            <td>
                                @if(!empty($file->job_title))
                                    {{ $file->job_title }}
                                @else
                                    @if($file->user->name == "系統管理員")
                                        系統管理員
                                    @else
                                        {{ $file->user->title }}
                                    @endif
                                @endif                            
                            </td>
                            <td>
                                @if(file_exists(storage_path($f.'/'.$file->name)))
                                    {{ date ("Y-m-d H:i:s",filemtime(storage_path($f.'/'.$file->name))) }}
                                @else
                                    <small class="text-danger">已遺失</small>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    @foreach ($clouds as $cloud)
                        <?php
                        $file_p = $path.'&'.$cloud->id;
                        ?>
                        <tr>
                            <td scope="row">
                                <span class="text-primary">
                                    <i class="fas fa-cloud" aria-hidden="true"></i> 
                                    <a href="{{ $cloud->url }}" target="_blank" rel="noopener noreferrer" aria-label="開啟雲端連結：{{ $cloud->name }} (另開新視窗)">
                                        {{ $cloud->name }}
                                    </a>
                                    <span class="visually-hidden">(另開新視窗)</span>
                                </span>
                            </td>
                            <td>
                                雲端連結
                                @auth
                                    @if(($cloud->user_id == auth()->user()->id and !empty($check_exec)) or ($cloud->job_title == auth()->user()->title) or auth()->user()->admin==1)
                                        <a href="{{ route('open_files.edit',[$cloud->id,$file_p]) }}" class="btn btn-link p-0 text-primary venobox" data-vbtype="iframe" aria-label="編輯雲端連結：{{ $cloud->name }}">
                                            <i class='fas fa-edit' aria-hidden="true"></i>
                                        </a>
                                        <a href="#!" id="delete_file{{ $cloud->id }}" onclick="sw_confirm1('確定刪除？','{{ route('open_files.delete',$file_p) }}')" aria-label="刪除雲端連結：{{ $cloud->name }}">
                                            <i class="fas fa-minus-square text-danger" aria-hidden="true"></i>
                                        </a>
                                    @endif
                                @endauth
                            </td>
                            <td>
                                -
                            </td>
                            <td>
                                @if(!empty($cloud->job_title))
                                    {{ $cloud->job_title }}
                                @else
                                    @if($cloud->user->name == "系統管理員")
                                        系統管理員
                                    @else
                                        {{ $cloud->user->title }}
                                    @endif
                                @endif                            
                            </td>
                            <td>
                                {{ $cloud->created_at }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <hr>
            
            @can('create', \App\Models\Upload::class)
                <div class="card my-4">
                    <h2 class="card-header h5">新增區塊</h2>
                    <div class="card-body">
                        @include('layouts.hd')
                        
                        <form action="{{ route('open_files.create_folder') }}" method="POST" id="this_form1">
                            @csrf
                            <div class="mb-3">
                                <!-- 無障礙 HM1150100C 修正：標籤屬性 -->
                                <label for="folder_name"><strong>1. 子目錄</strong></label>
                                <input type="text" name="name" id="folder_name" class="form-control" placeholder="請輸入子目錄名稱" required aria-label="子目錄名稱">
                            </div>
                            <div class="mb-3">
                                <input type="hidden" name="folder_id" value="{{ $folder_id }}">
                                <input type="hidden" name="path" value="{{ $path }}">
                                <button type="button" class="btn btn-success btn-sm" id="this_form1_button" onclick="sw_confirm2('您確定新增子目錄嗎?','this_form1','this_form1_button')">
                                    <i class="fas fa-plus me-1" aria-hidden="true"></i> 新增子目錄
                                </button>
                            </div>
                        </form>
                        <hr>
                        
                        @include('layouts.errors')
                        @if($per < 100)
                            <form action="{{ route('open_files.upload_file') }}" method="POST" enctype="multipart/form-data" id="this_form2">
                                @csrf
                                <div class="mb-3">
                                    <label for="upload_files">
                                        <strong>2. 上傳檔案 (不大於10MB，若為文字檔，請改為 [ 
                                            <a href="https://www.ndc.gov.tw/cp.aspx?n=d6d0a9e658098ca2" target="_blank" rel="noopener noreferrer">ODF格式<span class="visually-hidden">(另開新視窗)</span></a> ] [ 
                                            <a href="{{ asset('ODF.pdf') }}" target="_blank" rel="noopener noreferrer">詳細公文 (PDF)<span class="visually-hidden">(另開新視窗)</span></a> ] [ 
                                            <a href="{{ asset('office2016_odt_pdf.png') }}" target="_blank" rel="noopener noreferrer">轉檔教學<span class="visually-hidden">(另開新視窗)</span></a> ] )
                                        </strong>
                                        <small class="text-secondary d-block">支援格式：csv, txt, zip, jpeg, png, pdf, odt, ods, mp3</small>
                                    </label>
                                    <input type="file" name="files[]" id="upload_files" class="form-control" multiple required aria-label="選擇上傳檔案">
                                </div>
                                <div class="mb-3">
                                    <input type="hidden" name="folder_id" value="{{ $folder_id }}">
                                    <input type="hidden" name="path" value="{{ $path }}">
                                    <button type="button" class="btn btn-success btn-sm" id="this_form2_button" onclick="sw_confirm2('您確定新增檔案嗎?','this_form2','this_form2_button')">
                                        <i class="fas fa-plus me-1" aria-hidden="true"></i> 新增檔案
                                    </button>
                                </div>
                            </form>
                        @endif

                        <form action="{{ route('open_files.upload_cloud') }}" method="POST" id="this_form3">
                            @csrf
                            <div class="mb-3">
                                <label for="cloud_name"><strong>3. 雲端連結</strong></label>
                                <input type="text" name="name" id="cloud_name" class="form-control mb-2" placeholder="請輸入雲端資源名稱" required aria-label="雲端資源名稱">
                                <label for="cloud_url" class="visually-hidden">雲端網址</label>
                                <input type="text" name="url" id="cloud_url" class="form-control" placeholder="請輸入雲端網址 (例：https://...)" required aria-label="雲端網址">
                            </div>
                            <div class="mb-3">
                                <input type="hidden" name="folder_id" value="{{ $folder_id }}">
                                <input type="hidden" name="path" value="{{ $path }}">
                                <button type="button" id="this_form3_button" class="btn btn-success btn-sm" onclick="sw_confirm2('您確定新增雲端檔案嗎?','this_form3','this_form3_button')">
                                    <i class="fas fa-plus me-1" aria-hidden="true"></i> 新增雲端連結
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endcan
        </div>
    </div>

    <script>
        var submitcount = 0;
        function submitOnce (form){
            if (submitcount == 0){
                submitcount++;
                return true;
            } else{
                alert('正在操作,請不要重複提交,謝謝!');
                return false;
            }
        }
        function change_button1(){
            $("#submit_button").removeAttr('onclick');
            $("#submit_button").attr('disabled','disabled');
            $("#submit_button").addClass('disabled');
            $("#this_form").submit();
        }
        function change_button2(){
            $("#submit_button2").removeAttr('onclick');
            $("#submit_button2").attr('disabled','disabled');
            $("#submit_button2").addClass('disabled');
            $("#this_form2").submit();
        }
        function open_window(url, name)
        {
            window.open(url, name, 'statusbar=no,scrollbars=yes,status=yes,resizable=yes,width=900,height=300');
        }
    </script>
@endsection
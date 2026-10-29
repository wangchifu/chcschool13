var lfm = function(options, cb) {
    var route_prefix = (options && options.prefix) ? options.prefix : '/laravel-filemanager';
    window.open(route_prefix + '?type=' + (options.type || 'file'), 'FileManager', 'width=900,height=600');
    window.SetUrl = cb;
};

// 1. 主要編輯器 (tiny_editor)
tinymce.init({
    selector: 'textarea#tiny_editor',
    language: 'zh_TW',
    language_url: '/js/zh_TW.js',
    // 🎯 1. 允許在 body 內嵌 <style> 標籤 (預設 body 不允許放 style)
    valid_children: '+body[style]',

    // 🎯 2. 允許 <style> 與 <link> 標籤保留及其屬性，不被過濾刪除
    extended_valid_elements: 'style[type|lang],link[rel|href|type|media]',

    // 🎯 3. 防止 TinyMCE 自動清理或轉換 HTML 標籤
    verify_html: false,
    cleanup: false,
    // 網址處理關鍵設定：確保輸出以 "/" 開頭的相對路徑 (不帶 http://網域)
    relative_urls: false,
    remove_script_host: true,
    convert_urls: true,
    
    // 將 Bootstrap 5 樣式灌入編輯區
    content_css: 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css',

    plugins: 'fullscreen code table image link lists paste', 
    toolbar: 'fullscreen code undo redo | bold italic underline forecolor backcolor | alignleft aligncenter alignright alignjustify | table image link unlink openlink | bullist numlist outdent indent | removeformat',

    // 設定點擊「插入圖片 / 檔案」時觸發的 File Picker
    file_picker_callback: function (callback, value, meta) {
        var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
        var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;
        
        var type = (meta.filetype === 'image' || meta.fieldname === 'image') ? 'Images' : 'Files';
        var cmsURL = '/laravel-filemanager?editor=' + meta.fieldname + '&type=' + type;

        tinymce.activeEditor.windowManager.openUrl({
            url : cmsURL,
            title : '檔案與圖片管理器',
            width : x * 0.8,
            height : y * 0.8,
            resizable : "yes",
            close_previous : "no",
            onMessage: (api, message) => {
                var rawUrl = message.content;
                var relativePath = rawUrl;

                // 🎯 方法二：自動擷取相對路徑 (例如：/storage/079999/photos/1.png)
                try {
                    var urlObj = new URL(rawUrl, window.location.origin);
                    relativePath = urlObj.pathname;
                } catch (e) {
                    relativePath = rawUrl.replace(/^https?:\/\/[^\/]+/, '');
                }

                // 🎯 自動取得圖片原始寬高，解決寬高為空值的問題
                if (meta.fieldname === 'image') {
                    var img = new Image();
                    img.onload = function () {
                        callback(relativePath, {
                            width: img.naturalWidth || img.width,
                            height: img.naturalHeight || img.height,
                            alt: ''
                        });
                    };
                    img.onerror = function () {
                        callback(relativePath);
                    };
                    img.src = relativePath;
                } else {
                    callback(relativePath);
                }
            }
        });
    },

    automatic_uploads: true,
    valid_elements: '*[*]', 
    extended_valid_elements: '*[*]',
    verify_html: false,
    forced_root_block: false,    // 避免自動包裹 <p> 標籤
    remove_trailing_brs: false, // 不刪除尾部 <br>

    // 拖曳或剪貼簿直接上傳圖片處理
    images_upload_handler: function (blobInfo) {
        let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let formData = new FormData();
        formData.append('file', blobInfo.blob(), blobInfo.filename());

        return fetch('/tinymce_upload_image', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'same-origin'
        })
        .then(response => {
            if (!response.ok) {
                return Promise.reject('伺服器回應錯誤，狀態碼：' + response.status);
            }
            return response.json();
        })
        .then(data => {
            if (data && data.location) {
                // 🎯 方法二：將 API 回傳的 location 轉為相對路徑
                try {
                    var urlObj = new URL(data.location, window.location.origin);
                    return urlObj.pathname;
                } catch (e) {
                    return data.location.replace(/^https?:\/\/[^\/]+/, '');
                }
            } else {
                return Promise.reject('伺服器回傳的 JSON 不包含 `location` 欄位');
            }
        })
        .catch(error => {
            console.error('圖片上傳錯誤:', error);
            return Promise.reject('圖片上傳失敗');
        });
    }
});

// 2. 精簡版編輯器 (small_editor)
tinymce.init({
    selector: 'textarea#small_editor',
    language: 'zh_TW',
    language_url: '/js/zh_TW.js',
    
    // 網址處理關鍵設定一致化
    relative_urls: false,
    remove_script_host: true,
    convert_urls: true,
    
    content_css: 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css',
    plugins: 'fullscreen link lists paste', 
    toolbar: 'undo redo | fontsize | bold italic underline forecolor | alignleft aligncenter alignright | link unlink | bullist numlist | removeformat fullscreen',
    
    verify_html: true, 
    allowed_elements: 'p,span,br,strong,em,u,ul,ol,li,a',
    extended_valid_elements: 'a[href|target=_blank|title],span[style],p[style]',

    forced_root_block: false,      // 避免自動包裹 <p> 標籤
    remove_trailing_brs: false    // 不刪除尾部 <br>
});
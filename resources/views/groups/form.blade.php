<div class="card my-4 shadow-sm">
    <h2 class="card-header h5">群組資料</h2>
    <div class="card-body">
        <div class="mb-3">
            <label for="name" class="form-label fw-bold">名稱 <span class="text-danger">*</span></label>
            <input type="text" 
                   name="name" 
                   id="name" 
                   value="{{ old('name', $group->name ?? null) }}" 
                   class="form-control" 
                   placeholder="名稱" 
                   required>
        </div>
        <div class="mb-3">
            <div class="form-check">
                <input type="checkbox" 
                       name="disable" 
                       value="1" 
                       id="disable" 
                       class="form-check-input" 
                       {{ old('disable', $group->disable ?? false) ? 'checked' : '' }}>
                <label class="form-check-label" for="disable">停用</label>
            </div>
        </div>
        <div class="mb-2">
            <button type="button" class="btn btn-primary btn-sm" onclick="sw_confirm2('確定儲存嗎？','this_form1')">
                <i class="fas fa-save me-1" aria-hidden="true"></i> 儲存設定
            </button>
        </div>
    </div>
</div>
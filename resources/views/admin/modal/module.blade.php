<form id="quickAddForm" method="POST" action="{{ route('admin.courses.module.store') }}" class="ajax-form">
    @csrf
    <input type="hidden" id="moduleId" name="moduleId" value="{{ $data != '' ? $data->id : '' }}">
    <input type="hidden" id="course_id" name="course_id" value="{{ $course_id }}">
    <div class="col-12 mb-3">
        <label for="moduleName" class="form-label">
            <i class="fas fa-graduation-cap me-1"></i>
            Module Name <span class="text-danger">*</span>
        </label>
        <input type="text" class="form-control" id="moduleName" placeholder="Enter module name" name="moduleName" value="{{ $data != '' ? $data->title : '' }}">
    </div>
    
    <div class="col-12 mb-3">
        <label for="moduleStatus" class="form-label">
            <i class="fas fa-toggle-on me-1"></i>
            Status
        </label>
        <select class="form-select active-select" id="moduleStatus" name="moduleStatus">
            <option value="active" {{ $data != '' && $data->status == 'active' ? 'selected' : 'selected' }}>Active</option>
            <option value="inactive" {{ $data != '' && $data->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
    </div>
    <div class="modal-footer p-0">
        <button type="submit" class="btn btn-primary save-module">
            <i class="fas fa-save me-1"></i>
            {{ $data != '' ? 'Update' : 'Save' }} Module
        </button>
    </div>
</form>

<script src="{{asset('portal/js/ajax-validation.js')}}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
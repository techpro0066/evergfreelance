<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" />

<style>
    .dropify-wrapper .dropify-message p {
        font-size: 18px !important;
    }

    .dropify {
        height: 100% !important;
    }

    #progressBar {
        width: 100%;
        height: 12px;
        background: linear-gradient(90deg, #e2e8f0 0%, #f1f5f9 100%);
        border-radius: 10px;
        overflow: hidden;
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
        border: 1px solid #cbd5e1;
    }

    #progressBar::-webkit-progress-bar {
        background: linear-gradient(90deg, #e2e8f0 0%, #f1f5f9 100%);
        border-radius: 10px;
    }

    #progressBar::-webkit-progress-value {
        background: linear-gradient(90deg, #3b82f6 0%, #1d4ed8 50%, #1e40af 100%);
        border-radius: 10px;
        transition: width 0.3s ease-in-out;
        box-shadow: 0 2px 4px rgba(59, 130, 246, 0.3);
    }

    #progressBar::-moz-progress-bar {
        background: linear-gradient(90deg, #3b82f6 0%, #1d4ed8 50%, #1e40af 100%);
        border-radius: 10px;
    }

    #progressText {
        font-size: 14px;
        font-weight: 600;
        color: #374151;
        margin-top: 8px;
        text-align: center;
        background: linear-gradient(90deg, #3b82f6, #1d4ed8);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
</style>

<form id="quickAddForm" method="POST" action="{{ route('admin.courses.lesson.store') }}" class="ajax-form">
    @csrf
    <input type="hidden" name="moduleId" value="{{ $moduleId}}">
    <input type="hidden" name="course_id" value="{{ $courseId }}">
    <input type="hidden" name="lessonId" value="{{ $data->id ?? '' }}">
    <div class="col-12 mb-3">
        <label for="lessonName" class="form-label">
            <i class="fas fa-book me-1"></i>
            Lesson Name <span class="text-danger">*</span>
        </label>
        <input type="text" class="form-control" id="lessonName" placeholder="Enter lesson name" name="name" value="{{ $data->title ?? '' }}">
    </div>
    <div class="col-12 mb-3">
        <label for="lessonStatus" class="form-label">
            <i class="fas fa-toggle-on me-1"></i>
            Status
        </label>
        <select class="form-select active-select" id="lessonStatus" name="status">
            <option value="active" {{ $data != '' && $data->status == 'active' ? 'selected' : 'selected' }}>Active</option>
            <option value="inactive" {{ $data != '' && $data->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
    </div>
    <div class="col-12 mb-3">
        <label for="lessonType" class="form-label">
            <i class="fas fa-file-alt me-1"></i>
            Type
        </label>
        <select class="form-select type-select" id="lessonType" name="type">
            <option value="pdf" {{ $data != '' && $data->type == 'pdf' ? 'selected' : 'selected' }}>PDF</option>
            <option value="video" {{ $data != '' && $data->type == 'video' ? 'selected' : '' }}>Video</option>
        </select>
    </div>
    <div class="col-12 mb-3 pdf-div {{ $data != '' && $data->type == 'video' ? 'd-none' : '' }}">
        <label for="lessonFile" class="form-label">
            <i class="fas fa-file-upload me-1"></i>
            PDF
        </label>
        <input type="file" class="form-control dropify" id="lessonFile" name="pdf_file" data-allowed-file-extensions="pdf" data-default-file="{{ $data->file ?? '' }}">
    </div>
    <div class="col-12 mb-3 video-div {{ $data != '' && $data->type == 'video' ? '' : 'd-none' }}">
        <label for="lessonFile" class="form-label">
            <i class="fas fa-file-upload me-1"></i>
            Video
        </label>
        <input type="file" class="form-control dropify video-file" id="lessonFile" name="video_file" data-allowed-file-extensions="mp4" data-default-file="{{ $data->file ?? '' }}">
        <input type="hidden" name="video_file_path" value="{{ $data->file ?? '' }}">
    </div>
    <div class="col-12 mb-3 video-div {{ $data != '' && $data->type == 'video' ? '' : 'd-none' }}">
        <progress id="progressBar" value="0" max="100"></progress>
        <p id="progressText">0%</p>
    </div>
    <input type="hidden" name="hidden_file" value="{{ $data->file ?? '' }}">
    <div class="modal-footer p-0">
        <button type="submit" class="btn btn-primary save-lesson">
            <i class="fas fa-save me-1"></i>
            Save Lesson
        </button>
    </div>
</form>

<script src="{{asset('portal/js/ajax-validation.js')}}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
    $('.dropify').dropify();

    $('.type-select').on('change', function() {
        var type = $(this).val();
        if(type == 'pdf') {
            $('.pdf-div').removeClass('d-none');
            $('.video-div').addClass('d-none');
        } else {
            $('.pdf-div').addClass('d-none');
            $('.video-div').removeClass('d-none');
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    $('.video-file').on('change', async function(e) {
        const file = e.target.files[0];
        const extension = file.name.split('.').pop();
        if(extension != 'mp4') {
            swal({
                title: "Error!",
                text: "Only .mp4 files are allowed",
                icon: "error"
            });
            return;
        }
        if (!file) return;

        const chunkSize = 2 * 1024 * 1024; // 2 MB
        const totalChunks = Math.ceil(file.size / chunkSize);
        let uploaded = 0;

        for (let i = 0; i < totalChunks; i++) {
            const start = i * chunkSize;
            const end = Math.min(start + chunkSize, file.size);
            const chunk = file.slice(start, end);

            let formData = new FormData();
            formData.append("file", chunk);
            formData.append("fileName", file.name);
            formData.append("chunkIndex", i);

            await axios.post("/upload-chunk", formData, {
                onUploadProgress: (progressEvent) => {
                    let percent = Math.round(((uploaded + progressEvent.loaded) / file.size) * 100);
                    document.getElementById("progressBar").value = percent;
                    document.getElementById("progressText").innerText = percent + "%";
                }
            });

            uploaded += chunk.size;
        }

        // After all chunks uploaded → Merge request
        const response = await axios.post("/merge-chunks", {
            fileName: file.name,
            totalChunks: totalChunks
        });
        
        $('input[name="video_file_path"]').val(response.data.path);
    });

    $(document).on('click', '.dropify-clear', function(e) {
        $('#progressBar').val(0);
        $('#progressText').text('0%');
        var file_url = $('input[name="video_file_path"]').val();
        
        axios.delete("/delete-file", {
            data: {
                file_url: file_url
            }
        });
        $('input[name="video_file_path"]').val('');
    });
</script>
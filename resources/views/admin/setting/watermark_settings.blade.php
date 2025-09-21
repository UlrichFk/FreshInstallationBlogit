<!-- Enable/Disable Watermark -->
<div class="col-md-6 mb-3">
    <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" id="is_enabled" name="is_enabled" 
               {{ $watermarkSettings->is_enabled ? 'checked' : '' }}>
        <label class="form-check-label" for="is_enabled">
            Enable Watermark
        </label>
    </div>
</div>

<!-- Watermark Type -->
<div class="col-md-6 mb-3">
    <label class="form-label">Watermark Type</label>
    <select class="form-select" name="type" id="watermark_type">
        <option value="text" {{ $watermarkSettings->type === 'text' ? 'selected' : '' }}>Text</option>
        <option value="image" {{ $watermarkSettings->type === 'image' ? 'selected' : '' }}>Image</option>
    </select>
</div>

<!-- Text Watermark Settings -->
<div id="text_settings" class="col-md-6 mb-3" style="display: {{ $watermarkSettings->type === 'text' ? 'block' : 'none' }};">
    <label class="form-label">Watermark Text</label>
    <input type="text" class="form-control" name="text" value="{{ $watermarkSettings->text }}" 
           placeholder="{{ __("lang.admin_enter_watermark_text") }}">
</div>

<div id="text_font_settings" class="col-md-6 mb-3" style="display: {{ $watermarkSettings->type === 'text' ? 'block' : 'none' }};">
    <label class="form-label">Font Family</label>
    <select class="form-select" name="font_family">
        <option value="Arial" {{ $watermarkSettings->font_family === 'Arial' ? 'selected' : '' }}>Arial</option>
        <option value="Helvetica" {{ $watermarkSettings->font_family === 'Helvetica' ? 'selected' : '' }}>Helvetica</option>
        <option value="Times New Roman" {{ $watermarkSettings->font_family === 'Times New Roman' ? 'selected' : '' }}>Times New Roman</option>
        <option value="Georgia" {{ $watermarkSettings->font_family === 'Georgia' ? 'selected' : '' }}>Georgia</option>
        <option value="Verdana" {{ $watermarkSettings->font_family === 'Verdana' ? 'selected' : '' }}>Verdana</option>
    </select>
</div>

<!-- Image Watermark Settings -->
<div id="image_settings" class="col-md-6 mb-3" style="display: {{ $watermarkSettings->type === 'image' ? 'block' : 'none' }};">
    <label class="form-label">Watermark Image</label>
    <input type="file" class="form-control" name="watermark_image" accept="image/*">
    @if($watermarkSettings->image_path)
        <div class="mt-2">
            <small class="text-muted">Current: {{ $watermarkSettings->image_path }}</small>
            <br>
            <img src="{{ $watermarkSettings->getImageUrl() }}" alt="Current Watermark" style="max-width: 100px; max-height: 100px;" class="mt-1">
        </div>
    @endif
</div>

<!-- Position Settings -->
<div class="col-md-6 mb-3">
    <label class="form-label">Position</label>
    <select class="form-select" name="position">
        <option value="top-left" {{ $watermarkSettings->position === 'top-left' ? 'selected' : '' }}>Top Left</option>
        <option value="top-right" {{ $watermarkSettings->position === 'top-right' ? 'selected' : '' }}>Top Right</option>
        <option value="bottom-left" {{ $watermarkSettings->position === 'bottom-left' ? 'selected' : '' }}>Bottom Left</option>
        <option value="bottom-right" {{ $watermarkSettings->position === 'bottom-right' ? 'selected' : '' }}>Bottom Right</option>
        <option value="center" {{ $watermarkSettings->position === 'center' ? 'selected' : '' }}>Center</option>
    </select>
</div>

<!-- Opacity -->
<div class="col-md-6 mb-3">
    <label class="form-label">Opacity (%)</label>
    <input type="range" class="form-range" name="opacity" min="0" max="100" value="{{ $watermarkSettings->opacity }}" 
           oninput="this.nextElementSibling.value = this.value">
    <output>{{ $watermarkSettings->opacity }}</output>
</div>

<!-- Size -->
<div class="col-md-6 mb-3">
    <label class="form-label">Size (%)</label>
    <input type="range" class="form-range" name="size" min="5" max="100" value="{{ $watermarkSettings->size }}" 
           oninput="this.nextElementSibling.value = this.value">
    <output>{{ $watermarkSettings->size }}</output>
</div>

<!-- Color (only for text) -->
<div class="col-md-6 mb-3" id="color_setting" style="display: {{ $watermarkSettings->type === 'text' ? 'block' : 'none' }};">
    <label class="form-label">Text Color</label>
    <input type="color" class="form-control form-control-color" name="color" value="{{ $watermarkSettings->color }}" 
           title="Choose text color">
</div>

<!-- Application Settings -->
<div class="col-md-3 mb-3">
    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="apply_to_original" 
               {{ $watermarkSettings->apply_to_original ? 'checked' : '' }}>
        <label class="form-check-label" for="apply_to_original">
            Original Images
        </label>
    </div>
</div>

<div class="col-md-3 mb-3">
    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="apply_to_768x428" 
               {{ $watermarkSettings->apply_to_768x428 ? 'checked' : '' }}>
        <label class="form-check-label" for="apply_to_768x428">
            768x428 (Slider)
        </label>
    </div>
</div>

<div class="col-md-3 mb-3">
    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="apply_to_327x250" 
               {{ $watermarkSettings->apply_to_327x250 ? 'checked' : '' }}>
        <label class="form-check-label" for="apply_to_327x250">
            327x250 (Articles)
        </label>
    </div>
</div>

<div class="col-md-3 mb-3">
    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="apply_to_80x45" 
               {{ $watermarkSettings->apply_to_80x45 ? 'checked' : '' }}>
        <label class="form-check-label" for="apply_to_80x45">
            80x45 (Thumbnails)
        </label>
    </div>
</div>

<!-- Test Watermark Button -->
<div class="col-12 mb-3">
    <button type="button" class="btn btn-primary" onclick="testWatermark()">
        <i class="ti ti-eye me-1"></i> Test Watermark
    </button>
</div>

<!-- Test Result Modal -->
<div class="modal fade" id="testResultModal" tabindex="-1" aria-labelledby="testResultModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="testResultModalLabel">Watermark Test Result</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="testResultContent">
                    <!-- Test result will be loaded here -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Watermark Settings JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const watermarkType = document.getElementById('watermark_type');
    const textSettings = document.getElementById('text_settings');
    const textFontSettings = document.getElementById('text_font_settings');
    const imageSettings = document.getElementById('image_settings');
    const colorSetting = document.getElementById('color_setting');

    watermarkType.addEventListener('change', function() {
        if (this.value === 'text') {
            textSettings.style.display = 'block';
            textFontSettings.style.display = 'block';
            imageSettings.style.display = 'none';
            colorSetting.style.display = 'block';
        } else {
            textSettings.style.display = 'none';
            textFontSettings.style.display = 'none';
            imageSettings.style.display = 'block';
            colorSetting.style.display = 'none';
        }
    });
});

function testWatermark() {
    const button = event.target;
    const originalText = button.innerHTML;
    
    // Show loading state
    button.innerHTML = '<i class="ti ti-loader ti-spin me-1"></i> Testing...';
    button.disabled = true;

    fetch('{{ url("admin/watermark/test") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('testResultContent').innerHTML = `
                <div class="text-center">
                    <h6 class="text-success mb-3">Watermark test successful!</h6>
                    <img src="${data.test_image_url}" alt="Test Watermark" class="img-fluid border rounded" style="max-width: 100%;">
                    <p class="mt-3 text-muted">This is how your watermark will appear on images.</p>
                </div>
            `;
        } else {
            document.getElementById('testResultContent').innerHTML = `
                <div class="text-center">
                    <h6 class="text-danger mb-3">Test failed</h6>
                    <p class="text-muted">${data.error}</p>
                </div>
            `;
        }
        
        // Show modal
        new bootstrap.Modal(document.getElementById('testResultModal')).show();
    })
    .catch(error => {
        document.getElementById('testResultContent').innerHTML = `
            <div class="text-center">
                <h6 class="text-danger mb-3">Error occurred</h6>
                <p class="text-muted">${error.message}</p>
            </div>
        `;
        new bootstrap.Modal(document.getElementById('testResultModal')).show();
    })
    .finally(() => {
        // Restore button state
        button.innerHTML = originalText;
        button.disabled = false;
    });
}
</script> 
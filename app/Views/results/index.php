<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <h2><?= $title ?></h2>
    
    <div class="card">
        <div class="card-header">
            <h5>Select Class and Section</h5>
        </div>
        <div class="card-body">
            <form action="<?= base_url('results/class') ?>" method="post">
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="class_id" class="form-label">Class</label>
                            <select class="form-select" id="class_id" name="class_id" required>
                                <option value="">Select Class</option>
                                <?php foreach ($classes as $class): ?>
                                    <option value="<?= $class['id'] ?>"><?= $class['class'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="section_id" class="form-label">Section</label>
                            <select class="form-select" id="section_id" name="section_id" required>
                                <option value="">Select Section</option>
                                <!-- Will be populated via AJAX -->
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="exam_id" class="form-label">Exam</label>
                            <select class="form-select" id="exam_id" name="exam_id" required>
                                <option value="">Select Exam</option>
                                <!-- Add exam options here -->
                            </select>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">View Results</button>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('class_id').addEventListener('change', function() {
        const classId = this.value;
        const sectionDropdown = document.getElementById('section_id');
        
        // Clear current options
        sectionDropdown.innerHTML = '<option value="">Select Section</option>';
        
        if (classId) {
            // Fetch sections via AJAX
            fetch('<?= base_url('results/getSections') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'class_id=' + classId
            })
            .then(response => response.json())
            .then(data => {
                data.forEach(section => {
                    const option = document.createElement('option');
                    option.value = section.id;
                    option.textContent = section.section;
                    sectionDropdown.appendChild(option);
                });
            });
        }
    });
</script>
<?= $this->endSection() ?> 
<?php $title = "Categories"; ?>
<?php include_once "layout/header.php"; ?>
<?php
$categories = new Categories();

if (isset($_GET['category_id']) && isset($_GET['category_sub_id'])) {
    $id = $_GET['category_id'];
    $category = $categories->getCategoryById($id);

    $subId = $_GET['category_sub_id'];
    $subCategory = $categories->getSubCategoryById($subId);
}
?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <?= $title ?> Detail - <?= $category['category_name'] ?>
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="category-list.php"><?= $title ?></a></li>
                        <li class="breadcrumb-item"><a href="category-detail.php?id=<?= $category['category_id'] ?>"><?= $category['category_name'] ?> Detail</a></li>
                        <li class="breadcrumb-item active">Add <?= $category['category_name'] ?> Detail</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">
                                <?= htmlspecialchars($title) ?> Detail - <?= htmlspecialchars($category['category_name']) ?>
                            </h4>
                            <div class="card-tools">
                                <form action="" method="get">
                                    <input type="hidden" name="category_id" value="<?= $category['category_id'] ?>">
                                    <input type="hidden" name="category_sub_id" value="<?= $subCategory['category_sub_id'] ?>">
                                    <div class="input-group">
                                        <select class="form-control" name="year" onchange="this.form.submit()">
                                            <option value="">Select Year</option>
                                            <?php for ($i = date('Y'); $i >= 2020; $i--) : ?>
                                                <!-- if dont have get selected current year -->
                                                <?php if (!isset($_GET['year']) && $i == date('Y')) : ?>
                                                    <option value="<?= $i ?>" selected>
                                                        <?= $i ?>
                                                    </option>
                                                <?php else : ?>
                                                    <option value="<?= $i ?>" <?= isset($_GET['year']) && $_GET['year'] == $i ? 'selected' : '' ?>>
                                                        <?= $i ?>
                                                    </option>
                                                <?php endif; ?>
                                            <?php endfor; ?>
                                        </select>
                                        <div class="input-group-append">
                                            <a href="category-document-form.php?category_id=<?= urlencode($category['category_id']) ?>&category_sub_id=<?= urlencode($subCategory['category_sub_id']) ?>" class="btn btn-primary">
                                                <i class="fas fa-plus"></i> Add Document
                                            </a>
                                        </div>
                                        <!-- download as zip -->
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-success" onclick="downloadZip('<?= $category['category_name'] ?>')">
                                                <i class="fas fa-download"></i> Download ZIP
                                            </button>
                                        </div>
                                        <div class="input-group-append">
                                            <a href="category-list.php" class="btn btn-secondary">
                                                <i class="fas fa-arrow-left"></i> Back
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card-body">
                            <?= display_flash_message(); ?>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="table-default2">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Title</th>
                                            <th>Description</th>
                                            <th>Date</th>
                                            <th width="20%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $downloadZip = []; ?>
                                        <?php foreach ($categories->getDocumentsByCategorySubId($subId) as $key => $document) : ?>
                                            <?php if (isset($_GET['year']) && date('Y', strtotime($document['document_date'])) == $_GET['year']) : ?>
                                                <tr>
                                                    <td><?= $key + 1 ?></td>
                                                    <td><?= $document['document_title'] ?></td>
                                                    <td><?= $document['document_description'] ?></td>
                                                    <td><?= date('d M Y', strtotime($document['document_date'])) ?></td>
                                                    <td class="text-center">
                                                        <a href="<?= base_url('assets/dist/documents/' . $document['document_file']) ?>" target="_blank" class="btn btn-sm btn-info">
                                                            <i class="fas fa-file"></i> File
                                                        </a>
                                                        <a href="category-document-form.php?category_id=<?= $category['category_id'] ?>&category_sub_id=<?= $subCategory['category_sub_id'] ?>&document_id=<?= $document['document_id'] ?>" class="btn btn-sm btn-warning">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-danger" onclick="deleteDocument(<?= $document['document_id'] ?>)">
                                                            <i class="fas fa-trash"></i> Delete
                                                        </button>
                                                    </td>
                                                </tr>
                                                <?php $downloadZip[] = [
                                                    'url' => base_url('assets/dist/documents/' . $document['document_file']),
                                                    'name' => $document['document_title'] . '.' . pathinfo($document['document_file'], PATHINFO_EXTENSION)
                                                ]; ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php include_once "layout/footer.php"; ?>
<!-- zip download all file link -->
<!-- jszip cdn -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.6.0/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
<script>
    async function downloadZip(documentName) {
        const zip = new JSZip();
        const downloadZip = <?= json_encode($downloadZip) ?>;
        const promises = downloadZip.map(async (file) => {
            const response = await fetch(file.url);
            const blob = await response.blob();
            zip.file(file.name, blob);
        });
        await Promise.all(promises);
        zip.generateAsync({
            type: "blob"
        }).then(function(content) {
            saveAs(content, documentName + ".zip");
        });
    }
</script>
<script>
    function deleteDocument(documentId) {
        // sweetalert
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to delete this document?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // ajax
                $.ajax({
                    url: 'category-document-delete.php',
                    type: 'POST',
                    data: {
                        document_id: documentId
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 'success') {
                            Swal.fire(
                                'Deleted!',
                                'Document has been deleted.',
                                'success'
                            ).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire(
                                'Failed!',
                                'Failed to delete document.',
                                'error'
                            );
                        }
                    }
                });
            }
        });
    }
</script>
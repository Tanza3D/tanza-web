<div class="page__controlbar">
    <div class="page__controlbar-left">
        <p class="title">Portfolio</p>
    </div>
    <div class="page__controlbar-right">
        <div class="button" onclick="editing = false; toggleUploadModal();">Add Item</div>
    </div>
</div>

<div class="page__content">

</div>

<div class="modal upload-modal modal-hidden" id="upload-modal">
    <div class="modal-inner">
        <div class="modal-content">
            <div class="modal-right">
                <p>Name</p>
                <input type="text" name="name" id="name" onkeyup="updateData()">
                <br>
                <p>Description</p>
                <input type="text" name="description" id="description" onkeyup="updateData()">
                <br>
                <p>Type (0 = branding, 1 = web, 2 = cover)</p>
                <input type="text" name="type" id="type" onkeyup="updateData()">
                <br>
                <p>Date</p>
                <input type="datetime-local" name="date" id="date_up" onkeyup="updateData()">
                <br>
                <p>Link</p>
                <input type="text" name="link" id="link" onkeyup="updateData()">
                <br>
                <p>Image</p>
                <div class="images">
                <div id="drop_zone" ondrop="dropHandler(event);" ondragover="dragOverHandler(event);">
                        <p>Drag one or more files to this <i>drop zone</i>.</p>
                    </div>

                    <div class="image-grid" id="image-grid">

                    </div>
                </div>
            </div>
        </div>
        <div class="modal-toolbar">

            <div class="button" onclick="uploadProject()">Upload</div>
            <div class="button" onclick="toggleUploadModal();">Close</div>

        </div>
    </div>
</div>
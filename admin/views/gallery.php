<div class="page__controlbar">
    <div class="page__controlbar-left">
        <p class="title">Gallery</p>
    </div>
    <div class="page__controlbar-right">
        <div class="button" onclick="toggleUploadModal();">Add Item</div>
    </div>
</div>

<div class="page__content">
    <div class="gallery__list" id="gallery-list">
        <div class="gallery__item">
            <img src="https://tanza.hubza.co.uk/art/upload/small/1671300616_1.5.png">
            <div class="gallery__item-options">
                <div class="gallery__item-info">
                    <h3>Title</h3>
                    <p>Date <span>/ Name</span> <strong>tags</strong></p>
                </div>
                <div class="gallery__item-controls hidden">
                    <div style="display: flex;">
                        <div>
                            <p>Name</p>
                            <input type="text" id="edit_1671300616_name" value="V6 vs V7">
                            <p>Tags</p>
                            <input type="text" id="edit_1671300616_tags" value="">
                            <p>Date</p>
                            <input type="date" id="edit_1671300616_date" value="2022-12-17">
                            <input type="text" id="edit_1671300616_filename" value="1671300616_1.5.png" hidden="">
                        </div>
                        <div style="margin-left: 10px; flex: 1;">
                            <p>Description</p>
                            <textarea rows="3" id="edit_1671300616_description"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="gallery__item-buttons-info">
                <div class="button">Edit</div>
            </div>
            <div class="gallery__item-buttons-edit hidden">
                <div class="button">Canel</div>
                <div class="button">Save</div>
            </div>
        </div>
    </div>
</div>

<div class="modal upload-modal modal-hidden" id="upload-modal">
    <div class="modal-inner">
        <div class="modal-content">
            <div class="modal-left">
                <img id="preview">
            </div>
            <div class="modal-right">
                <p>Select image to upload:</p>
                <input type="file" name="file" id="file">
                <br>
                <p>Name (will be automatically filled out)</p>
                <input type="text" name="name" id="name">
                <br>
                <p>Date (will be automatically filled out)</p>
                <input type="date" name="date" id="date">
            </div>
        </div>
        <div class="modal-toolbar">

        <div class="button" onclick="uploadImage()">Upload</div>
        <div class="button" onclick="toggleUploadModal();">Close</div>

        </div>
    </div>
</div>
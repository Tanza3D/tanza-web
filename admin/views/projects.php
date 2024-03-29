<div class="page__controlbar">
    <div class="page__controlbar-left">
        <p class="title">Projects</p>
    </div>
    <div class="page__controlbar-right">
        <div class="button" onclick="editing = false; toggleUploadModal();">Add Item</div>
    </div>
</div>

<div class="page__content">
    <div id="col_1" class="col">

    </div>
    <div id="col_2" class="col">

    </div>
</div>

<div class="modal upload-modal modal-hidden" id="upload-modal">
    <div class="modal-inner">
        <div class="modal-content">
            <div class="modal-left" id="preview">
                
            </div>
            <div class="modal-right">
                <div noshowineditor>
                <p>Internal name (example: project-loved)</p>
                <input type="text" name="internalName" id="internalName" onkeyup="updateData()">
                <br>
                <p>Background Image</p>
                <input noshowineditor type="file" name="background" id="background" onchange="updateData()">
                <br>
                <p>Logo Image</p>
                <input noshowineditor type="file" name="logo" id="logo" onchange="updateData()">
                <br>
                </div>
                <p>Project Name (example; Project Loved. used just for screenreaders)</p>
                <input type="text" name="name" id="name" onkeyup="updateData()">
                <br>
                <p>Project Description</p>
                <input type="text" name="description" id="description" onkeyup="updateData()">
                <p>Extra Description</p>
                <textarea type="text" name="extraDescription" id="extraDescription" onkeyup="updateData()"></textarea>
                <br>
                <p>Badge</p>
                <input type="text" name="badge" id="badge" onkeyup="updateData()">
                <br>
                <p>Project Date</p>
                <input type="date" name="date" id="date" onchange="updateData()">
                <br>
                <p>Order</p>
                <input type="number" name="order" id="order" onkeyup="updateData()">
                <br>
                <p>Size</p>
                <select name="size" id="size" onchange="updateData()">
                    <option value="big">Big</option>
                    <option value="medium">Medium</option>
                    <option value="medium-centered">Medium Centered</option>
                    <option value="small">Small</option>
                </select>
                <p>OnClick</p>
                <input type="text" name="badge" id="click" onkeyup="updateData()">
                <br>
            </div>
        </div>
        <div class="modal-toolbar">

            <div class="button" onclick="uploadProject()">Upload</div>
            <div class="button" onclick="toggleUploadModal();">Close</div>

        </div>
    </div>
</div>
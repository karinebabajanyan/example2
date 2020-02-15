class FileList {
    constructor(...items) {
        // flatten rest parameter
        items = [].concat(...items);
        // check if every element of array is an instance of `File`
        if (items.length && !items.every(file => file instanceof File)) {
            throw new TypeError("expected argument to FileList is File or array of File objects");
        }
        // use `ClipboardEvent("").clipboardData` for Firefox, which returns `null` at Chromium
        // we just need the `DataTransfer` instance referenced by `.clipboardData`
        const dt = new ClipboardEvent("").clipboardData || new DataTransfer();
        // add `File` objects to `DataTransfer` `.items`
        for (let file of items) {
            dt.items.add(file)
        }
        return dt.files;
    }
}

    let photoUpload = document.getElementById('photo-upload'),
        imgUploadPreview = document.querySelector('.img-upload-preview');
    let j=0;
    let arr1=[];
    let ischeck;
    photoUpload.onchange = function () {
        $('#err_img').remove();
        $('#err_title').remove();
        $('#err_description').remove();
        // input.style.display="none";
        let all = imgUploadPreview.childElementCount+photoUpload.files.length;
        if (photoUpload.files.length > 10 || all > 10) {
            alert('You can only upload a maximum of 10 files'+all);
            alert(photoUpload.files.length);
        } else {
            for (let i = 0; i < photoUpload.files.length; i++) {
                // check files supported only images jpg - jpeg - gif
                if (/\.(jpe?g|png|gif)$/i.test(photoUpload.files[i].name) === false) {
                    alert("this type is not supported");
                    photoUpload.files[i] = null;
                    break;
                } else {
                    let reader = new FileReader;

                    reader.onload = function (event) {
                        j++;
                        var text=photoUpload.files[i].name;
                        let previewImage = document.createElement('label'),
                            newInput=input = document.createElement("input"),
                            previewImageBox = document.createElement('div'),
                            removeImage = document.createElement('i'),
                            removeIcon = document.createTextNode('x'),
                            checkImage=document.createElement('input');
                        newInput.type = "file";
                        newInput.name = "files[newfile][]";
                        newInput.style.display="none";
                        checkImage.type='radio';
                        checkImage.name='images';
                        checkImage.value= photoUpload.files[i].name;
                        checkImage.id= 'images'+j;
                        if(j===1 && imgUploadPreview.childElementCount === 0){
                            checkImage.checked=true;
                            ischeck=0;
                        }
                        previewImage.classList.add('drinkcard-cc');
                        previewImage.htmlFor='images'+j;
                        previewImage.style.backgroundImage='url('+reader.result+')';
                        if($.inArray(text,arr1)===-1){
                            newInput.files = new FileList(photoUpload.files[i]);
                            console.log(newInput.files)
                            removeImage.appendChild(removeIcon);
                            previewImageBox.appendChild(checkImage);
                            previewImageBox.appendChild(previewImage);
                            previewImageBox.classList.add('cc-selector-2','previewImage');
                            previewImageBox.appendChild(removeImage);
                            previewImageBox.appendChild(newInput);
                            imgUploadPreview.appendChild(previewImageBox);
                            removeImage.addEventListener('click', removeItem);
                            checkImage.addEventListener('click', checkedItem);
                        }

                        // confirm remove item
                        function removeItem(e) {
                            let index=arr1.length;
                            if(imgUploadPreview.childElementCount !== 1){
                                let radio=$(this).parent().next().children("input[type=radio]");
                                let this_radio=$(this).parent().children("input[type=radio]");
                                // let emement = $(this).parent().children("input[type=radio]").val();
                                for (var i=0;i<index;i++){
                                    if(arr1[i]== this_radio.val()){
                                        arr1.splice(i, 1);
                                        if(this_radio.is(':checked')) {
                                            radio.attr('checked', 'checked');
                                        }
                                        e.target.parentElement.remove();
                                    }
                                }

                            }
                        }
                        function checkedItem(e) {
                            ischeck=$(this).parent().index()
                        }
                        arr1.push(text);
                    }
                    // read file url
                    reader.readAsDataURL(event.target.files[i]);
                }
            }

        }
    }

$(".deleteItem").click(function(e){
    let id=$(this).parent().children("input[type=radio]").val();
    var that=e.target.parentElement;
    let radio=$(this).parent().next().children("input[type=radio]");
    let radio1=$(this).parent().parent().children().eq(0).children("input[type=radio]");
    let token = $('meta[name="csrf-token"]').attr('content')
    if(imgUploadPreview.childElementCount !== 1) {
        $.ajax({
            url: "/delete-image",
            type: 'post',
            data: {_token: token, id: id},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (result) {
                console.log(result)
                if (result == 1) {
                    that.remove();
                    if(radio.length==0){
                        radio1.attr('checked', 'checked');
                    }else{
                        radio.attr('checked', 'checked');
                    }
                } else if (result == 2) {
                    that.remove();
                }
            }
        });
    }
});
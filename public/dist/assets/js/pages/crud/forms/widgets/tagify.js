// Class definition
var KTTagifyDemos = function() {
    // Private functions
    var demo1 = function() {

        var input = document.getElementById('kt_tagify_1'),
            // init Tagify script on the above inputs
            tagify = new Tagify(input, {
                whitelist: ["Router","Laptop","HP","Komputer","Printer","PABX","Mesin Cuci","Dispenser","Kipas Angin","AC","Arduino","Mouse","Headset","Power Supply","CCTV","Proyektor","Magsafe","MAC","iPhone",'Android'],
                blacklist: ["Narkoba"], // <-- passed as an attribute in this demo
                originalInputValueFormat: valuesArr => valuesArr.map(item => item.value).join(',')
            })


        // "remove all tags" button event listener
        document.getElementById('kt_tagify_1_remove').addEventListener('click', tagify.removeAllTags.bind(tagify));

        // Chainable event listeners
        tagify.on('add', onAddTag)
            .on('remove', onRemoveTag)
            .on('input', onInput)
            .on('edit', onTagEdit)
            .on('invalid', onInvalidTag)
            .on('click', onTagClick)
            .on('dropdown:show', onDropdownShow)
            .on('dropdown:hide', onDropdownHide)

        // tag added callback
        function onAddTag(e) {
            // console.log("onAddTag: ", e.detail);
            // console.log("original input value: ", input.value)
            tagify.off('add', onAddTag) // exmaple of removing a custom Tagify event
        }

        // tag remvoed callback
        function onRemoveTag(e) {
            // console.log(e.detail);
            // console.log("tagify instance value:", tagify.value)
        }

        // on character(s) added/removed (user is typing/deleting)
        function onInput(e) {
            // console.log(e.detail);
            // console.log("onInput: ", e.detail);
        }

        function onTagEdit(e) {
            // console.log("onTagEdit: ", e.detail);
        }

        // invalid tag added callback
        function onInvalidTag(e) {
            // console.log("onInvalidTag: ", e.detail);
            
        }

        // invalid tag added callback
        function onTagClick(e) {
            // console.log(e.detail);
            // console.log("onTagClick: ", e.detail);
        }

        function onDropdownShow(e) {
            // console.log("onDropdownShow: ", e.detail)
        }

        function onDropdownHide(e) {
            // console.log("onDropdownHide: ", e.detail)
        }
    }

    var demo1Readonly = function() {
        // Readonly Mode
        var input = document.getElementById('kt_tagify_1_1'),
        tagify = new Tagify(input);

        tagify.addTags([{value:"laravel", color:"yellow", readonly: true}]);
    }



    return {
        // public functions
        init: function() {
            demo1();
            demo1Readonly();
        }
    };
}();

jQuery(document).ready(function() {
    KTTagifyDemos.init();
});

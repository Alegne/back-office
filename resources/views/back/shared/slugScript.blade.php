<script src="https://cdnjs.cloudflare.com/ajax/libs/speakingurl/14.0.1/speakingurl.min.js"></script>

<script>
    $(function() {
        $('.slug').keyup(function () {
            $(this).val(getSlug($(this).val()))
        })

        $('.libelle').keyup(function () {
            $('.slug').val(getSlug($(this).val()))
        })

        $('.titre ').keyup(function () {
            $('.slug').val(getSlug($(this).val()))
        })
    })
</script>

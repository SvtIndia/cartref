<template>
  <div>
    <Editor
        api-key="hp9awa02w8sokysr3vumjy3fzovcir6ugypb2o8mw7boq425"
        v-model="data_content"
        :init="{
          toolbar_mode: 'sliding',
          branding: false,
          height: height ?? 250,
          plugins: 'advcode advlist advtable anchor autolink autosave casechange charmap checklist codesample directionality emoticons export formatpainter help image insertdatetime link linkchecker lists media mediaembed nonbreaking pagebreak permanentpen powerpaste searchreplace table tinymcespellchecker visualblocks visualchars wordcount',
          toolbar: 'styleselect fontselect fontsizeselect | forecolor backcolor | undo redo spellcheckdialog | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | tinycomments | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
          tinycomments_mode: 'embedded',
          fontsize_formats: '6pt 8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 20pt 20pt 24pt 30pt 36pt 48pt 60pt 72pt 96pt',
          spellchecker_language: 'en_US',
          spellchecker_languages: 'English (United States)=en_US',
          typography_langs: [ 'en-US' ],
          typography_default_lang: 'en-US',
        }"
    />
  </div>
</template>
<script>
import Editor from "@tinymce/tinymce-vue";

export default {
  components: {
    Editor: Editor,
  },
  props: {
    initial_value: String,
    setVal: Function,
    height: String,
  },
  watch: {
    data_content(newValue, oldValue) {
      this.setVal(newValue);
    },
    initial_value(newValue) {
      this.data_content = newValue;
    }
  },
  data() {
    return {
      data_content: this.initial_value,
    }
  }

}
</script>
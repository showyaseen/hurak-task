<template>
  <b-container>
    <b-card
      class="mb-2"
      :style="{
        background: box.color,
        width: box.width + 'px',
        height: box.height + 'px',
      }"
    >
    </b-card>
  </b-container>
</template>

<script>
export default {
  props: {
    box: Object,
  }
};
</script>

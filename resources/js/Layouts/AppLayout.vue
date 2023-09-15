<script>
import FrontendLayout from '@/Layouts/FrontendLayout.vue';
import BackendLayout from '@/Layouts/BackendLayout.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';

export default {
  components: { FrontendLayout, BackendLayout, GuestLayout },
  computed: {
    layoutPosition() {
      const { component = '' } = this.$page;
      const fileName = [
        { code: 'Frontend', com: 'FrontendLayout' },
        { code: 'Backend', com: 'BackendLayout' },
      ];
      const position = fileName.find(({ code }) => component.includes(code));
      return position?.com ?? 'GuestLayout';
    },
  },
};
</script>

<template>
  <section id="app-layout">
    <component :is="layoutPosition">
      <slot />
    </component>
  </section>
</template>

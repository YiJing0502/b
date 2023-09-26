<script>
import 'bootstrap-icons/font/bootstrap-icons.css';
import { Head } from '@inertiajs/vue3';
export default {
  components: {
    Head,
  },
  data() {
    return {
      showSubMenu: false,
    };
  },
  methods: {
    toggleSubMenu() {
      this.showSubMenu = !this.showSubMenu;
    },
  },
};
</script>

<template>
  <Head title="menu" />
  <div class="menu">
    <input id="chevron-soft-switch" type="checkbox" hidden class="chevron-switch">
    <label for="chevron-soft-switch" class="chevron-label">
      <li tabindex="0" @click="toggleSubMenu" @keydown.enter="toggleSubMenu">
        <span>軟體</span>
        <i class="bi bi-plus" :class="{ 'hidden': !showSubMenu }"></i>
        <i class="bi bi-ban" :class="{ 'hidden': showSubMenu }"></i>
      </li>
      <div class="sub-dropdown-menu" :class="{ 'hidden': !showSubMenu }">
        <ul>
          <a href="#">
            <li tabindex="0">Windows應用程式</li>
          </a>
          <a href="#">
            <li tabindex="0">OneDrive</li>
          </a>
          <a href="#">
            <li tabindex="0">Outlook</li>
          </a>
          <a href="#">
            <li tabindex="0">Skype</li>
          </a>
          <a href="#">
            <li tabindex="0">OneNote</li>
          </a>
          <a href="#">
            <li tabindex="0">Microsoft Teams</li>
          </a>
        </ul>
      </div>
    </label>
  </div>
</template>

<style scoped>/* 使用 Tailwind CSS 类来样式化组件 */
.menu {
.sub-dropdown-menu {
    @apply transition-all duration-700 ease-in-out;
}
}

/* 在这里添加 Tailwind CSS 类，以适应您的样式 */</style>

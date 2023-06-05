<script setup lang="ts">
import { RouterView } from 'vue-router'
</script>

<template>
  <header>
    <h1>TODO LIST</h1>
  </header>
  <main>
    <div class="wrapper">
      <RouterView />
    </div>
  </main>
</template>

<style lang="scss" scoped>
main {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}

@media screen and (max-width: 1000px) {
  main {
    div.wrapper {
      width: 100%;
    }
  }
}
@media screen and (min-width: 1001px) {
  main {
    div.wrapper {
      width: 800px;
    }
  }
}
</style>

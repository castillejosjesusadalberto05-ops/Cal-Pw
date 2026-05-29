<template>
  <div>
    <div v-if="error" class="error-box">⚠️ {{ error }}</div>
    <div v-if="resultado !== null && !error" class="resultado-box">
      ✅ Resultado: {{ resultado }}
    </div>
  </div>
</template>

<script>
export default {
  props: {
    error: String,
    resultado: [Number, String]
  }
}
</script>
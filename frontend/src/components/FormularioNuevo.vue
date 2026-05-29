<template>
  <div>
    <h2>Calculadora</h2>
    <label>Número 1</label>
    <input type="text" v-model="num1" placeholder="Ingresa un número" />

    <label>Número 2</label>
    <input type="text" v-model="num2" placeholder="Ingresa otro número" />

    <label>Operación</label>
    <select v-model="oper">
      <option value="">-- Elige operación --</option>
      <option value="suma">Suma</option>
      <option value="resta">Resta</option>
      <option value="multiplicacion">Multiplicación</option>
      <option value="division">División</option>
    </select>

    <button @click="calcular">Calcular</button>
  </div>
</template>

<script>
export default {
  emits: ['calcular'],
  data() {
    return {
      num1: '',
      num2: '',
      oper: ''
    }
  },
  methods: {
    calcular() {
      if (!this.num1 || !this.num2 || !this.oper) {
        alert('Completa todos los campos.');
        return;
      }
      this.$emit('calcular', {
        num1: this.num1,
        num2: this.num2,
        oper: this.oper
      });
    }
  }
}
</script>
<template>
  <div class="tarjeta">
    <FormularioNuevo @calcular="procesar" />
    <MostrarResultado :error="error" :resultado="resultado" />
  </div>
</template>

<script>
import FormularioNuevo from './components/FormularioNuevo.vue'
import MostrarResultado from './components/MostrarResultado.vue'

export default {
  components: { FormularioNuevo, MostrarResultado },
  data() {
    return {
      error: '',
      resultado: null
    }
  },
  methods: {
    async procesar({ num1, num2, oper }) {
      this.error = '';
      this.resultado = null;

      try {
        const respuesta = await fetch('./calculadora.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ num1, num2, oper })
        });

        const data = await respuesta.json();
        if (data.ok) {
          this.resultado = data.resultado;
        } else {
          this.error = data.error;
        }
      } catch (e) {
        this.error = 'Error de comunicación con el servidor.';
      }
    }
  }
}
</script>
import Vue from 'vue';
import Vuetify from 'vuetify/lib';
import colors from 'vuetify/lib/util/colors'
import es from 'vuetify/es5/locale/es'
Vue.use(Vuetify);



export default new Vuetify({
   lang: {
      locales: { es },
      current: 'es',
   },
   theme: {
      themes: {
         light: {
            primary: '#5867dd',
            success: '#1dc9b7',
            warning: '#ffb822',
            danger: '#fd397a',
            secondary: colors.indigo.accent2,
            background: '#242939',
            brand: '#5d78ff',
            title: '#595d6e',
            subtitle: '#959cb6',
            btnbackground: '#e2e9ff',
            accent: '#00c5dc'
            
         },
      },
   },
});

<template>

    <Head>
        <title>Dashboard - Aplikasi Form Master</title>
    </Head>

    <body class="antialiased">
        <div id="app403">
            <div>403</div>
            <div class="txt">
                Access Forbidden<span class="blink">_</span>
            </div>
        </div>
    </body>
</template>

<style>
@import url("https://fonts.googleapis.com/css?family=Press+Start+2P");
html,
body {
  width: 100%;
  height: 100%;
  margin: 0;
}

#app403 {
  font-family: "Press Start 2P", cursive;
  box-sizing: border-box;
  padding: 1rem;
  background: black;
  display: flex;
  height: 100%;
  justify-content: center;
  align-items: center;
  color: #54fe55;
  text-shadow: 0px 0px 10px;
  font-size: 6rem;
  flex-direction: column;
}
#app403 .txt {
  font-size: 1.8rem;
}

@keyframes blink {
  0% {
    opacity: 0;
  }
  49% {
    opacity: 0;
  }
  50% {
    opacity: 1;
  }
  100% {
    opacity: 1;
  }
}
.blink {
  animation-name: blink;
  animation-duration: 1s;
  animation-iteration-count: infinite;
}
</style>

<script>
    //import layout
    import LayoutApp from '../../Layouts/App.vue';

    //import Heade and useForm from Inertia
    import { Head } from '@inertiajs/inertia-vue3';

    export default {

        //layout
        layout: LayoutApp,

        //register component
        components: {
            Head,
        },

        props: {
            sides: Object,
        },

        computed: {
            sides () {
                return this.$page.props.sides
            }
        }
    }
</script>

<style>

</style>
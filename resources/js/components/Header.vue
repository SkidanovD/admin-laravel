<template>
    <header class="header">
        <div class="header__wrapper wrapper">
            <div class="header__content">
                <div class="row align-items-center">
                    <div class="col-2">
                        <div class="header__logo logo"><img src="img/logo.svg"  alt="logo" /></div>
                    </div>
                    <div class="col-10">
                        <vueNav></vueNav>
                    </div>
                </div>
            </div>
        </div>
    </header>
</template>

<script>
import vueNav from './../components/Nav';

export default {
    components: {
        vueNav,
    },
}
</script>


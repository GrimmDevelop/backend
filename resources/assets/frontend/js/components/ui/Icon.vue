<template>
    <span class="icon inline-block" :class="format">
        <svg class="w-full h-full fill-current">
            <use :href="iconHref"></use>
        </svg>
    </span>
</template>

<script>
    export default {
        name: "Icon",

        props: {
            spinner: {
                default: false,
            },
            icon: {},
            format: {
                default: '',
            },
        },

        computed: {
            iconHref() {
                return `#${this.icon}`;
            },
        }
    };
</script>

<style scoped>
    .icon {
        width: 20px;
        height: 20px;
    }
</style>

<template>
    <svg class="icon fill-current" :class="format">
        <use :href="iconHref"></use>
    </svg>
</template>

<script>
    export default {
        name: "Icon",

        props: {
            icon: {
                required: true,
            },
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

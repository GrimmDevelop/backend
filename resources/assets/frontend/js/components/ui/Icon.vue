<template>
    <span class="icon inline-block" :class="format"
          @click="$emit('click', $event)"
          @mousedown="$emit('mousedown', $event)"
          @mouseenter="$emit('mouseenter', $event)"
          @mouseleave="$emit('mouseleave', $event)"
          @mousemove="$emit('mousemove', $event)"
          @mouseout="$emit('mouseout', $event)"
          @mouseover="$emit('mouseover', $event)"
          @mouseup="$emit('mouseup', $event)">
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

<style scoped lang="scss">
    .icon {
        width: 20px;
        height: 20px;

        svg {
            pointer-events: all;
        }
    }
</style>

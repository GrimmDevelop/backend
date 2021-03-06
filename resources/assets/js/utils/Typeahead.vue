<template>
    <div>
        <input class="form-control"
               :id="id"
               :placeholder="placeholder"
               ref="searchInput"
               v-model="value"
               @keydown.up="up"
               @keydown.down="down"
               @keydown.enter.prevent="hit"
               @keydown.esc="reset"
               autocomplete="off">
        <ul class="list-group">
            <li v-for="(item, index) in results"
                :key="`result-${index}`"
                @click="itemClicked(item)"
                @mousemove="current = index"
                class="list-group-item typeahead-item"
                :class="{'active': index === current}">
                <slot name="list-item"
                      :item="item">
                    <span v-html="item"></span>
                </slot>
            </li>
            <li v-show="searched && results.length === 0"
                class="list-group-item">
                <span v-html="empty"></span>
            </li>
        </ul>
    </div>
</template>

<style>
    .typeahead-item {
        cursor: pointer;
    }
</style>

<script type="text/babel">
    import '../bootstrap';

    import debounce from 'lodash/debounce';

    export default {
        props: [
            'id', 'placeholder',
            'src', 'onHit', 'prepareResponse',
            'result', 'empty'
        ],

        data() {
            return {
                value: '',
                results: [],
                searched: false,
                current: 0
            };
        },

        watch: {
            value: debounce(function (value) {
                this.$http.get(this.src + encodeURIComponent(value)).then(({data}) => {
                    this.results = this.preparation(data);
                    this.searched = true;
                    this.current = 0;
                });
            }, 500),
        },

        methods: {
            preparation(response) {
                if (typeof this.prepareResponse == 'function') {
                    return this.prepareResponse(response);
                }

                return response;
            },

            itemClicked(item) {
                this.reset();

                if (typeof this.onHit == 'function') {
                    this.onHit(item);
                }
            },

            reset() {
                this.searched = false;
                this.results = [];
            },

            hit() {
                this.itemClicked(this.results[this.current]);
            },

            up() {
                if (this.current > 0) {
                    this.current--;
                }
            },

            down() {
                if (this.current < this.results.length - 1) {
                    this.current++;
                }
            },

            focus() {
                this.$refs.searchInput.focus();
            },
        }
    };
</script>

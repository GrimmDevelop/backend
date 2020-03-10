<template>
    <div class="letter">
        <h1 class="title" v-html="title"></h1>

        <div v-for="(group, groupIndex) in lineGroups"
             :key="`group-${groupIndex}`">
            <div v-for="(line, index) in lines(group)"
                 :key="`line-${groupIndex}-${index}`"
                 class="line"
                 :style="lineStyle(line)">
                <div class="line-no"
                     :class="numberClass(line, index)">
                    {{ lineNo(line, index) }}
                </div>
                <div class="line-text"
                     :class="textClass(line, index)"
                     :style="textStyle(line, index)"
                     v-html="line.innerHTML"></div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "LetterText",

        data() {
            return {
                data: null,
                lineGroupTag: 'line-group',
                lineTag: 'line',
            };
        },

        props: {
            text: {},
        },

        computed: {
            title() {
                return this.xml().querySelector("letter > title").innerHTML;
            },

            /**
             * @return {NodeList}
             */
            lineGroups() {
                return this.xml().querySelectorAll(`letter > ${this.lineGroupTag}`);
            },
        },

        mounted() {
        },

        methods: {
            xml() {
                if (this.data === null) {
                    let parser = new DOMParser();
                    this.data = parser.parseFromString(this.text, "text/xml");
                }

                return this.data;
            },

            lines(group) {
                return group.querySelectorAll(this.lineTag);
            },

            /**
             * @param {Node} line
             * @param {Number} index
             * @return {Number} number of line starting with 0
             */
            lineNo(line, index) {
                let group = line.parentNode;

                let lines = 0;
                while ((group = group.previousElementSibling) && group.tagName === this.lineGroupTag) {
                    lines += this.lines(group).length;
                }

                return lines + index + 1;
            },

            lineStyle(line) {
                return {
                    'margin-top': line.getAttribute('top') + "px",
                };
            },

            numberClass(line, index) {
                return {
                    'is-five': this.lineNo(line, index) % 5 === 0,
                };
            },

            textClass(line) {
                let isFirst = !line.previousElementSibling;
                let isLast = !line.nextElementSibling;

                return {
                    'np': isFirst,
                    'align-left': isLast || line.getAttribute("align") === 'left',
                    'align-right': line.getAttribute("align") === 'right',
                    'align-center': line.getAttribute("align") === 'center',
                };
            },

            textStyle(line) {
                return {
                    'margin-left': line.getAttribute('left') + "px",
                };
            }
        },
    };
</script>

<style scoped lang="scss">

    .letter {
        width: 600px;
        margin: auto;
    }

    .title {
        margin-left: 2rem;
        font-size: 16px;
        font-weight: bold;
        margin-bottom: 2rem;
    }

    .line {
        width: 100%;
        overflow: hidden;
        display: flex;

        .line-no {
            width: 2rem;
            color: #f9f9f9;

            &.is-five {
                color: black;
            }
        }

        .line-text {
            flex: 1;
            text-align: justify;
            text-align-last: justify;
            white-space: nowrap;

            &.align-left {
                text-align: left;
                text-align-last: left;
            }

            &.align-right {
                text-align: right;
                text-align-last: right;
            }

            &.np {
                margin-left: 1.5rem;
            }
        }
    }

</style>

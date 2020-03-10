<template>
    <div class="letter">
        <h1 class="title" v-html="title"></h1>

        <div v-for="(group, groupIndex) in lineGroups"
             :key="`group-${groupIndex}`">
            <div v-for="(line, index) in lines(group)"
                 :key="`line-${groupIndex}-${index}`"
                 class="line">
                <div class="line-no" :class="lineNo(line, index) % 5 === 4 ? 'is-five' : ''">
                    {{ lineNo(line, index) + 1 }}
                </div>
                <div class="line-text"
                     :class="classFor(line, index)"
                     :style="styleFor(line, index)"
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
                /** @var {Document} data  */
                data: null
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
                return this.xml().querySelectorAll("letter > line-group");
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
                return group.querySelectorAll("line");
            },

            /**
             * @param {Node} line
             * @param {Number} index
             * @return {Number} number of line starting with 0
             */
            lineNo(line, index) {
                let group = line.parentNode;

                let indexs = 0;
                while ((group = group.previousElementSibling)) {
                    console.log(group);
                    indexs++;

                    if(indexs > 10) {
                        console.log("fishy!");
                        break;
                    }
                }

                let lines = 0;

                for (let i = 0; i < this.lineGroups.length; i++) {
                    let group = this.lineGroups.item(i);

                    if (group === parent) {
                        break;
                    }

                    lines += this.lines(group).length;
                }

                return lines + index;
            },

            classFor(line, index) {
                let next = line.nextElementSibling;

                console.log(next);

                let isLast = next && next.getAttribute("new-paragraph") === 'new-paragraph';

                return {
                    'np': line.getAttribute("new-paragraph") === 'new-paragraph',
                    'align-left': isLast || line.getAttribute("align") === 'left',
                    'align-right': line.getAttribute("align") === 'right',
                    'align-center': line.getAttribute("align") === 'center',
                };
            },

            styleFor(line) {
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

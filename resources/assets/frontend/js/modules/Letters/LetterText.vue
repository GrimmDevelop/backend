<template>
    <div ref="textContainer">
        <div :style="cssVars" class="letter" v-html="html"></div>
    </div>
</template>

<script>
    import {nodeMap} from '@/js/utils/Nodes';

    export default {
        name: "LetterText",

        data() {
            return {
                paragraphTag: 'p',
                lineBreakTag: 'lb',
                formatTag: 'hi',
                width: 0,
            };
        },

        props: {
            text: {},
        },

        computed: {
            cssVars() {
                return {
                    '--titel-font-size': this.width / 37 + 'px',
                    '--text-font-size': this.width / 40 + 'px',
                };
            },

            xml() {
                let parser = new DOMParser();
                return parser.parseFromString(this.text, "application/xml");
            },

            html() {
                let html = "";

                html += this.title();

                html += this.body();

                return html;
            }
        },

        mounted() {
            this.$nextTick(() => {
                // TODO: recalculate when column is resized
                window.addEventListener('resize', this.getWindowWidth);
                this.getWindowWidth();
            });
        },

        methods: {
            title() {
                const title = this.xml.querySelector("letter > title").innerHTML;
                return `<h1 class="title">${title}</h1>`;
            },

            body() {
                let body = '<div class="letter-body">';

                this.lineNo = 0;

                body += this.format(this.xml.querySelector(`letter > body`));

                body += '</div>';

                return body;
            },

            format(node) {
                let body = "";

                if (this.isTextNode(node)) {
                    body += node.textContent.trim();
                } else if (this.isLineBreak(node)) {
                    body += "<span class='break'> </span>";
                    this.lineNo++;
                } else {
                    // format
                    if (node.tagName.toLowerCase() === this.formatTag) {
                        body += `<span class="${node.getAttribute('rendition').substr(1)}">${nodeMap(node.childNodes, this.format).join('')}</span>`;
                    } else if (node.tagName.toLowerCase() === this.paragraphTag) {
                        body += `<div class="paragraph">${nodeMap(node.childNodes, this.format).join('')}</div>`;
                    } else {
                        body += nodeMap(node.childNodes, this.format).join('');
                    }
                }
                return body;
            },

            isTextNode(node) {
                return node.nodeType === 3;
            },

            isLineBreak(node) {
                return node.nodeType === 1 && node.tagName.toLowerCase() === this.lineBreakTag;
            },

            getWindowWidth() {
                this.width = this.$refs.textContainer.clientWidth;
            },
        },

        beforeDestroy() {
            window.removeEventListener('resize', this.getWindowWidth);
        }
    };
</script>

<style lang="scss">

    .letter {
        padding: 0 1rem 0 1rem;
        max-width: 100%;

        .title {
            font-size: var(--titel-font-size);
            font-weight: bold;
            margin-bottom: 2rem;
        }

        .letter-body {
            .paragraph {
                margin: 0;
                font-size: var(--text-font-size);
                text-align: justify;
                white-space: nowrap;
                text-indent: 1.5rem;

                &:first-child {
                    text-indent: 0;
                }
            }

            .indent {
                margin-left: 1.5rem;
            }

            .break {
                white-space: pre-line;
            }

            .c {
                display: block;
                text-align: center;
            }

            .left {
                display: block;
                text-align: left;
            }

            .right {
                display: block;
                text-align: right;
            }

            .et {
                margin-left: 2em;
            }

            @for $i from 2 through 20 {
                .et#{$i} {
                    margin-left: #{$i * 2}em;
                }
            }
        }
    }

</style>

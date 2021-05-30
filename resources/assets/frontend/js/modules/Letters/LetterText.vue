<template>
    <div class="letter" v-html="html"></div>
</template>

<script>
    import {nodeMap} from '../../../../js/utils/Nodes';

    export default {
        name: "LetterText",

        data() {
            return {
                paragraphTag: 'p',
                lineBreakTag: 'lb',
                formatTag: 'hi',
            };
        },

        props: {
            text: {},
        },

        computed: {
            xml() {
                let parser = new DOMParser();
                return parser.parseFromString(this.text, "text/html");
            },

            html() {
                let html = "";

                html += this.title();

                html += this.body();

                return html;
            }
        },

        methods: {
            title() {
                console.log("xml: ", this.xml)
                const title = this.xml.querySelector("html > head").innerHTML;
                console.log("Title: ", title)
                return `<h1 class="title">${title}</h1>`;
            },

            body() {
                let body = '<div class="letter-body">';

                this.lineNo = 0;

                body += this.format(this.xml.querySelector(`html > body`));

                body += '</div>';
                console.log("Body: ", body)
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
                    if (node.tagName === this.formatTag) {
                        body += `<span class="${node.getAttribute('rendition').substr(1)}">${nodeMap(node.childNodes, this.format).join('')}</span>`;
                    } else if (node.tagName === this.paragraphTag) {
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
                return node.nodeType === 1 && node.tagName === this.lineBreakTag;
            }
        },
    };
</script>

<style lang="scss">

    .letter {
        width: 600px;
        max-width: 100%;
        margin: auto;

        .title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 2rem;
        }

        .letter-body {
            .paragraph {
                margin: 0;
                font-size: 16px;
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

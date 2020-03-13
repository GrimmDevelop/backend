<template>
    <div class="letter" v-html="html">
        <!--<div v-for="(paragraph, groupIndex) in paragraphs"
             :key="`group-${groupIndex}`">
            <div v-for="(line, index) in paragraph"
                 :key="`line-${groupIndex}-${index}`"
                 class="line"
                 :style="lineStyle(line)">
                <div class="line-no"
                     :class="numberClass(line.number)">
                    {{ line.number }}
                </div>
                <div class="line-text"
                     :class="textClass(line)"
                     :style="textStyle(line)"
                     v-html="line.text"></div>
            </div>
        </div>-->
    </div>
</template>

<script>
    import {nodeMap} from '../../../../js/utils/Nodes';

    export default {
        name: "LetterText",

        data() {
            return {
                data: null,
                paragraphTag: 'p',
                lineBreakTag: 'lb',
            };
        },

        props: {
            text: {},
        },

        computed: {
            xml() {
                let parser = new DOMParser();
                return parser.parseFromString(this.text, "text/xml");
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
                const title = this.xml.querySelector("letter > title").innerHTML;

                return `<h1 class="title">${title}</h1>`;
            },

            body() {
                let body = '<div class="letter-body">';

                let paragraphs = this.xml.querySelectorAll(`letter > ${this.paragraphTag}`);

                this.lineNo = 0;

                paragraphs.forEach((p, index) => {
                    body += "<p>";

                    if (index > 0) {
                        body += '<span class="indent"> </span>';
                    }

                    p.childNodes.forEach((node) => {
                        body += this.format(node);
                    });

                    body += "</p>";

                    this.lineNo++;
                });

                body += '</div>';

                return body;
            },

            lineStyle(line) {
                return null;
                return {
                    'margin-top': line.getAttribute('top') + "px",
                };
            },

            numberClass(line) {
                return {
                    'is-five': line % 5 === 0,
                };
            },

            textClass(line) {
                return;
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
                return;
                return {
                    'margin-left': line.getAttribute('left') + "px",
                };
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
                    if (node.tagName === 'hi') {
                        body += `<span class="${node.getAttribute('rendition').substr(1)}">${nodeMap(node.childNodes, this.format).join('')}</span>`;
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
            p {
                margin: 0;
                font-size: 16px;
                text-align: justify;
                text-align-last: justify;
                white-space: nowrap;
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
                text-align-last: center;
            }

            .left {
                display: block;
                text-align: left;
                text-align-last: left;
            }

            .right {
                display: block;
                text-align: right;
                text-align-last: right;
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
    }

</style>

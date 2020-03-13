<template>
    <div class="letter">
        <h1 class="title" v-html="title"></h1>

        <div v-for="(paragraph, groupIndex) in paragraphs"
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
        </div>
    </div>
</template>

<script>
    import {nodeMap} from "../../../../js/utils/Nodes";

    export default {
        name: "LetterText",

        data() {
            return {
                data: null,
                paragraphTag: 'p',
                lineBreakTag: 'lb',
                title: null,
                paragraphs: [],
            };
        },

        props: {
            text: {},
        },

        watch: {
            text: {
                immediate: true,
                handler() {
                    this.parseXml();
                },
            },
        },

        methods: {
            xml() {
                if (this.data === null) {
                    let parser = new DOMParser();
                    this.data = parser.parseFromString(this.text, "text/xml");
                }

                return this.data;
            },

            parseXml() {
                this.title = this.xml().querySelector("letter > title").innerHTML;

                let paragraphs = this.xml().querySelectorAll(`letter > ${this.paragraphTag}`);

                let lineNo = 1;

                this.paragraphs = nodeMap(paragraphs, (p) => {
                    let paragraph = [];

                    let line = "";
                    p.childNodes.forEach((node) => {
                        if (this.isTextNode(node)) {
                            line += node.textContent.trim();
                        } else if (this.isLineBreak(node)) {
                            paragraph.push({
                                number: lineNo++,
                                text: line,
                            });
                            line = "";
                        } else {
                            // format
                            line += this.format(node);
                        }
                    });

                    if (line !== "") {
                        paragraph.push({
                            number: lineNo++,
                            text: line,
                        });
                    }

                    return paragraph;
                }).filter((a) => a);
            },

            paragraph(group) {
                console.log(group, group.childNodes);
                return group.childNodes;
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
                if (this.isTextNode(node)) {
                    return node.textContent;
                }

                return nodeMap(node.childNodes, (childNode) => {
                    return this.format(childNode);
                }).join('');
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

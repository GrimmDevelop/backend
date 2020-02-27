#!/usr/bin/env node

const svgstore = require('svgstore');
const htmlclean = require('htmlclean');
const sh = require('shelljs');
const fs = require('fs');
const path = require('path');
const cwd = process.cwd();

const sprites = svgstore();

const OUTPUT_FILE_NAME = 'resources/svg/sprites.svg';

const files = sh.find('resources/svg/zondicons')
    .filter(file => file.match(/\.svg$/))
    .filter(file => !file.match(new RegExp(`${path.sep}${OUTPUT_FILE_NAME}$`)));

files.forEach(file => {
    const id = path.basename(file, '.svg');
    const contents = fs.readFileSync(file, 'utf8');
    sprites.add(id, contents);
});

let output = htmlclean(sprites.toString());

const style = '<style>:target{display:block}</style>';
output = output.replace(/^(<\?xml[^>]*\?>[\w]*<!DOCTYPE[^>]*>[\w]*<svg[^>]*>)/i, `$1${style}`);

const outputFile = path.join(cwd, OUTPUT_FILE_NAME);
fs.writeFileSync(outputFile, output);

console.info('Merged %s files into %s', files.length, outputFile);

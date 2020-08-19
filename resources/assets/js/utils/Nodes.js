/**
 * @param {NodeList} nodeList
 * @param {CallableFunction} callback
 * @return {Array}
 */
export function nodeMap(nodeList, callback) {
    return Array.from(nodeList.entries()).map((entry) => {
        return callback(entry[1]);
    });
}

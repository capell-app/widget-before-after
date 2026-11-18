import assert from 'node:assert/strict'
import { readFileSync } from 'node:fs'
import test from 'node:test'
import vm from 'node:vm'

const source = readFileSync(
    new URL('../../resources/dist/widget.js', import.meta.url),
    'utf8',
)

test('moving the comparison updates the position and its spoken text', () => {
    let input
    const range = {
        value: '50',
        attributes: {},
        setAttribute(name, value) {
            this.attributes[name] = value
        },
        addEventListener: (event, listener) => {
            input = listener
        },
    }
    const properties = {}
    const root = {
        dataset: { positionText: ':percent% of the after image shown' },
        classList: { contains: () => false, add() {} },
        style: { setProperty: (name, value) => (properties[name] = value) },
        querySelector: () => range,
    }
    vm.runInNewContext(source, {
        document: { querySelectorAll: () => [root], addEventListener() {} },
    })
    range.value = '72'
    input({ currentTarget: range })
    assert.equal(properties['--comparison-position'], '72%')
    assert.equal(
        range.attributes['aria-valuetext'],
        '72% of the after image shown',
    )
})

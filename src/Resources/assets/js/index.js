import * as components from './components'

export default function (Vue, args) {
    Object.values(components).forEach(component => {
        Vue.component(component.name, component);
    })
}
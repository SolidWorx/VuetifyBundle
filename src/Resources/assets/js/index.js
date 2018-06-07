import * as components from './components'

function VuetifyBundle(Vue) {
    Object.values(components).forEach(component => {
        Vue.component(component.name, component);
    })
}

if (typeof window !== 'undefined' && window.Vue) {
    window.Vue.use(VuetifyBundle);
}

export default VuetifyBundle

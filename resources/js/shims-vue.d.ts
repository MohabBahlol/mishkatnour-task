import { DefineComponent } from 'vue'

declare module '*.vue' {
    const component: DefineComponent<{}, {}, any>
    export default component
}

declare global {
    namespace JSX {
        interface Element extends Vue.VNode { }
        interface ElementClass extends Vue.ComponentPublicInstance { }
        interface ElementAttributesProperty {
            $props: any
        }
        interface IntrinsicElements {
            [elem: string]: any
        }
        interface IntrinsicAttributes extends Vue.ComponentCustomProps { }
    }
}

declare module '@bhplugin/vue3-datatable' {
    export interface Vue3DatatableSlots {
        actions?: (props: { row: any; value: any }) => any;
    }
}

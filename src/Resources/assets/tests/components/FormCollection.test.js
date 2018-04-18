import {mount} from '@vue/test-utils'
import FormCollection from '@/components/FormCollection'

describe('Form Collection', () => {
    it('renders a default item slot', () => {
        let vm = mount({
            template: '<form-collection><template slot="prototype" slot-scope="props"><div>{{ props.index }}</div></template></form-collection>',
            components: {
                FormCollection
            }
        });

        expect(vm.html()).toBe('<span><span><div>0</div></span></span>');
    });

    it('renders an add button', () => {
        let vm = mount({
            template: '<form-collection><template slot="prototype" slot-scope="props"></template><template slot="addButton"><button>Add</button></template></form-collection>',
            components: {
                FormCollection
            }
        });

        expect(vm.html()).toBe('<span><span></span><span><button>Add</button></span></span>');
    });

    it('doesn\'t render an add button if allowAdd is false', () => {
        let vm = mount({
            template: '<form-collection :allow-add="false"><template slot="prototype" slot-scope="props"></template><template slot="addButton"><button>Add</button></template></form-collection>',
            components: {
                FormCollection
            }
        });

        expect(vm.html()).toBe('<span><span></span></span>');
    });

    it('doesn\'t render an add button if allowAdd is false', () => {
        let vm = mount({
            template: '<form-collection :allow-add="false"><template slot="prototype" slot-scope="props"></template><template slot="addButton"><button>Add</button></template></form-collection>',
            components: {
                FormCollection
            }
        });

        expect(vm.html()).toBe('<span><span></span></span>');
    });

    it('can add a new item in the list', () => {
        let vm = mount({
            template: '<form-collection><template slot="prototype" slot-scope="props"><div>{{ props.index }}</div></template><template slot="addButton"><span class="add">Add</span></template></form-collection>',
            components: {
                FormCollection
            }
        });

        vm.find('.add').trigger('click');

        expect(vm.html()).toBe('<span><span><div>0</div></span><span><div>1</div></span><span><span class="add">Add</span></span></span>');
    });

    it('can add multiple new items in the list', () => {
        let vm = mount({
            template: '<form-collection><template slot="prototype" slot-scope="props"><div>{{ props.index }}</div></template><template slot="addButton"><span class="add">Add</span></template></form-collection>',
            components: {
                FormCollection
            }
        });

        vm.find('.add').trigger('click');
        vm.find('.add').trigger('click');
        vm.find('.add').trigger('click');

        expect(vm.html()).toBe('<span><span><div>0</div></span><span><div>1</div></span><span><div>2</div></span><span><div>3</div></span><span><span class="add">Add</span></span></span>');
    });

    it('doesn\'t render a delete button with only 1 item', () => {
        let vm = mount({
            template: '<form-collection><template slot="prototype" slot-scope="props"><div>{{ props.index }}</div></template><template slot="deleteButton" slot-scope="props"><button>Delete</button></template></form-collection>',
            components: {
                FormCollection
            }
        });

        expect(vm.html()).toBe('<span><span><div>0</div></span></span>');
    });

    it('renders a delete button with more than 1 item', () => {
        let vm = mount({
            template: '<form-collection><template slot="prototype" slot-scope="props"><div>{{ props.index }}</div></template><template slot="deleteButton" slot-scope="props"><button>Delete</button></template><template slot="addButton"><span class="add">Add</span></template></form-collection>',
            components: {
                FormCollection
            }
        });

        vm.find('.add').trigger('click');

        expect(vm.html()).toBe('<span><span><div>0</div><span><button>Delete</button></span></span><span><div>1</div><span><button>Delete</button></span></span><span><span class="add">Add</span></span></span>');
    });

    it('doesn\'t render a delete button with min items set', () => {
        let vm = mount({
            template: '<form-collection :min-items="3"><template slot="prototype" slot-scope="props"><div>{{ props.index }}</div></template><template slot="deleteButton" slot-scope="props"><button>Delete</button></template><template slot="addButton"><span class="add">Add</span></template></form-collection>',
            components: {
                FormCollection
            }
        });

        vm.find('.add').trigger('click');

        expect(vm.html()).toBe('<span><span><div>0</div></span><span><div>1</div></span><span><span class="add">Add</span></span></span>');
    });

    it('can remove an item', () => {
        let vm = mount({
            template: '<form-collection><template slot="prototype" slot-scope="props"><div :class="\'index-\' + props.index">{{ props.index }}</div></template><template slot="deleteButton" slot-scope="props"><button>Delete</button></template><template slot="addButton"><span class="add">Add</span></template></form-collection>',
            components: {
                FormCollection
            }
        });

        vm.find('.add').trigger('click');
        vm.find('.index-1 ~ span').trigger('click');

        expect(vm.html()).toBe('<span><span><div class="index-0">0</div></span><span><span class="add">Add</span></span></span>');
    });

    it('can re-indexes the items when one is removed', () => {
        let vm = mount({
            template: '<form-collection><template slot="prototype" slot-scope="props"><div :class="\'index-\' + props.index">{{ props.index }}</div></template><template slot="deleteButton" slot-scope="props"><button>Delete</button></template><template slot="addButton"><span class="add">Add</span></template></form-collection>',
            components: {
                FormCollection
            }
        });

        vm.find('.add').trigger('click');
        vm.find('.add').trigger('click');
        vm.find('.add').trigger('click');
        vm.find('.add').trigger('click');

        expect(vm.html()).toBe('<span><span><div class="index-0">0</div><span><button>Delete</button></span></span><span><div class="index-1">1</div><span><button>Delete</button></span></span><span><div class="index-2">2</div><span><button>Delete</button></span></span><span><div class="index-3">3</div><span><button>Delete</button></span></span><span><div class="index-4">4</div><span><button>Delete</button></span></span><span><span class="add">Add</span></span></span>');

        vm.find('.index-2 ~ span').trigger('click');

        expect(vm.html()).toBe('<span><span><div class="index-0">0</div><span><button>Delete</button></span></span><span><div class="index-1">1</div><span><button>Delete</button></span></span><span><div class="index-2">2</div><span><button>Delete</button></span></span><span><div class="index-3">3</div><span><button>Delete</button></span></span><span><span class="add">Add</span></span></span>');
    });

    it('can manually remove an item from the prototype slot', () => {
        let vm = mount({
            template: '<form-collection><template slot="prototype" slot-scope="props">{{ props.index }}<div :class="\'index-\' + props.index" @click="props.$bus.$emit(\'removeItem\', props.index)">Remove</div></template><template slot="addButton"><span class="add">Add</span></template></form-collection>',
            components: {
                FormCollection
            }
        });

        vm.find('.add').trigger('click');
        vm.find('.add').trigger('click');

        expect(vm.html()).toBe('<span><span>0<div class="index-0">Remove</div></span><span>1<div class="index-1">Remove</div></span><span>2<div class="index-2">Remove</div></span><span><span class="add">Add</span></span></span>');

        vm.find('.index-1').trigger('click');

        expect(vm.html()).toBe('<span><span>0<div class="index-0">Remove</div></span><span>1<div class="index-1">Remove</div></span><span><span class="add">Add</span></span></span>');
    });

    it('can manually add an item in the prototype slot', () => {
        let vm = mount({
            template: '<form-collection><template slot="prototype" slot-scope="props">{{ props.index }}<div :class="\'index-\' + props.index" @click="props.$bus.$emit(\'addItem\')">Add</div></template></form-collection>',
            components: {
                FormCollection
            }
        });

        expect(vm.html()).toBe('<span><span>0<div class="index-0">Add</div></span></span>');

        vm.find('.index-0').trigger('click');

        expect(vm.html()).toBe('<span><span>0<div class="index-0">Add</div></span><span>1<div class="index-1">Add</div></span></span>');
    });
});
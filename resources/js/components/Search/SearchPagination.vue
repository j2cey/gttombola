<template>
    <form
        v-if="show"
        class="tw-w-full md:tw-w-1/3 tw-mx-auto tw-mt-3 tw-grid tw-grid-cols-5 tw-gap-0 tw-text-gray-700"
    >
        <span
            :class="buttonClass('first')"
            class="tw-row-span-1 tw-flex tw-items-center tw-justify-center tw-border tw-rounded-l-sm"
            @click="goToFirst"
        >
            <double-angle-left class="tw-fill-current tw-h-4 tw-pointer-events-none" />
        </span>
        <span
            :class="buttonClass('prev')"
            class="tw-row-span-1 tw-flex tw-items-center tw-justify-center tw-border-t tw-border-b"
            @click="goToPrev"
        >
            <angle-left class="tw-fill-current tw-h-4 tw-pointer-events-none" />
        </span>
        <span class="tw-row-span-1 tw-relative">
            <select
                id="per_page"
                class="tw-appearance-none tw-rounded-none tw-block tw-w-full tw-bg-gray-200 focus:tw-bg-white tw-text-gray-700 tw-border tw-border-gray-400 focus:tw-border-gray-500 tw-py-3 tw-pl-4 tw-pr-8 tw-leading-tight focus:tw-outline-none"
                :class="{ 'tw-opacity-50': !hasPages }"
                :disabled="!hasPages"
                @change="change"
            >
                <option
                    v-for="page in pages"
                    :key="page"
                    :value="page"
                    :selected="current === page"
                >
                    {{ page }}
                </option>
            </select>
            <select-angle :class="{ 'tw-opacity-50': !hasPages }"></select-angle>
        </span>
        <span
            :class="buttonClass('next')"
            class="tw-row-span-1 tw-flex tw-items-center tw-justify-center tw-border-t tw-border-b"
            @click="goToNext"
        >
            <angle-right class="tw-fill-current tw-h-4 tw-pointer-events-none" />
        </span>
        <span
            :class="buttonClass('last')"
            class="tw-row-span-1 tw-flex tw-items-center tw-justify-center tw-border tw-rounded-r-sm"
            @click="goToLast"
        >
            <double-angle-right class="tw-fill-current tw-h-4 tw-pointer-events-none" />
        </span>
    </form>
</template>
<script>
    import { mapState, mapGetters, mapActions } from 'vuex';
    import AngleLeft from '../Icons/AngleLeft';
    import DoubleAngleLeft from '../Icons/DoubleAngleLeft';
    import AngleRight from '../Icons/AngleRight';
    import DoubleAngleRight from '../Icons/DoubleAngleRight';
    import SelectAngle from '../Form/SelectAngle';
    export default {
        name: 'SearchPagination',
        components: {
            AngleLeft,
            DoubleAngleLeft,
            AngleRight,
            DoubleAngleRight,
            SelectAngle
        },
        props: {
            group: {
                type: String,
                required: true
            },
            alwaysShow: {
                type: Boolean,
                default: false
            }
        },
        data() {
            return {
                defaultClass: 'tw-px-4 tw-py-2 tw-inline-flex tw-border-solid',
                activeClass:
                    'tw-cursor-pointer tw-border-gray-400 hover:tw-bg-gray-300 tw-text-gray-700',
                inactiveClass: 'tw-cursor-not-allowed tw-border-gray-300 tw-text-gray-300'
            };
        },
        computed: {
            ...mapState('search', ['params']),
            ...mapGetters('search', [
                'currentPage',
                'prevPage',
                'nextPage',
                'lastPage'
            ]),
            current() {
                return this.currentPage(this.group);
            },
            last() {
                return this.lastPage(this.group);
            },
            next() {
                return this.nextPage(this.group);
            },
            prev() {
                return this.prevPage(this.group);
            },
            hasPages() {
                return this.last > 1;
            },
            pages() {
                const length = this.last;
                return Array.from({ length }, (_, i) => 1 + i);
            },
            show() {
                if (this.alwaysShow) {
                    return true;
                }
                return this.hasPages;
            }
        },
        methods: {
            ...mapActions('search', ['store']),
            buttonActiveClass(isTrue) {
                return ' ' + (isTrue ? this.activeClass : this.inactiveClass);
            },
            buttonClass(action) {
                let css = this.defaultClass;
                switch (action) {
                    case 'first':
                    case 'prev':
                        css += this.buttonActiveClass(this.prev);
                        break;
                    case 'next':
                    case 'last':
                        css += this.buttonActiveClass(this.next);
                        break;
                }
                return css;
            },
            goTo(page = null) {
                if (!page || page === this.current) {
                    return;
                }
                this.store({
                    group: this.group,
                    params: Object.assign({}, this.params[this.group], { page })
                });
            },
            goToFirst() {
                this.goTo(1);
            },
            goToPrev() {
                this.goTo(this.prev);
            },
            goToNext() {
                this.goTo(this.next);
            },
            goToLast() {
                this.goTo(this.last);
            },
            change(event) {
                this.goTo(event.target.value);
            }
        }
    };
</script>

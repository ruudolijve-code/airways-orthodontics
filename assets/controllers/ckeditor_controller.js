import { Controller } from '@hotwired/stimulus';

import {
    Autoformat,
    BlockQuote,
    Bold,
    ClassicEditor,
    Essentials,
    Heading,
    Indent,
    Italic,
    Link,
    List,
    Paragraph,
    PasteFromOffice,
    Table,
    TableToolbar,
} from '../ckeditor5/ckeditor5.bundle.js';

export default class extends Controller {
    async connect() {
        if (this.editor) {
            return;
        }

        try {
            this.editor = await ClassicEditor.create(this.element, {
                licenseKey: 'GPL',

                plugins: [
                    Essentials,
                    Paragraph,
                    Heading,
                    Bold,
                    Italic,
                    Link,
                    List,
                    BlockQuote,
                    Table,
                    TableToolbar,
                    Indent,
                    Autoformat,
                    PasteFromOffice,
                ],

                toolbar: {
                    items: [
                        'undo',
                        'redo',
                        '|',
                        'heading',
                        '|',
                        'bold',
                        'italic',
                        '|',
                        'link',
                        'bulletedList',
                        'numberedList',
                        '|',
                        'blockQuote',
                        'insertTable',
                        '|',
                        'outdent',
                        'indent',
                    ],

                    shouldNotGroupWhenFull: true,
                },

                heading: {
                    options: [
                        {
                            model: 'paragraph',
                            title: 'Alinea',
                            class: 'ck-heading_paragraph',
                        },
                        {
                            model: 'heading2',
                            view: 'h2',
                            title: 'Kop 2',
                            class: 'ck-heading_heading2',
                        },
                        {
                            model: 'heading3',
                            view: 'h3',
                            title: 'Kop 3',
                            class: 'ck-heading_heading3',
                        },
                        {
                            model: 'heading4',
                            view: 'h4',
                            title: 'Kop 4',
                            class: 'ck-heading_heading4',
                        },
                    ],
                },

                table: {
                    contentToolbar: [
                        'tableColumn',
                        'tableRow',
                        'mergeTableCells',
                    ],
                },
            });

            this.form = this.element.closest('form');

            if (this.form) {
                this.submitHandler = () => {
                    this.syncToTextarea();
                };

                this.form.addEventListener(
                    'submit',
                    this.submitHandler,
                    true,
                );
            }

            /*
             * Extra zekerheid:
             * houd de textarea ook tijdens het typen bij.
             */
            this.editor.model.document.on(
                'change:data',
                () => {
                    this.syncToTextarea();
                },
            );
        } catch (error) {
            console.error(
                'CKEditor kon niet worden gestart.',
                error,
            );
        }
    }

    syncToTextarea() {
        if (!this.editor) {
            return;
        }

        const data = this.editor.getData();

        this.element.value = data;

        /*
         * Laat CKEditor zelf zijn source element ook bijwerken.
         */
        if (typeof this.editor.updateSourceElement === 'function') {
            this.editor.updateSourceElement(data);
        }
    }

    async disconnect() {
        if (!this.editor) {
            return;
        }

        this.syncToTextarea();

        if (this.form && this.submitHandler) {
            this.form.removeEventListener(
                'submit',
                this.submitHandler,
                true,
            );
        }

        try {
            await this.editor.destroy();
        } catch (error) {
            console.error(
                'CKEditor kon niet netjes worden afgesloten.',
                error,
            );
        }

        this.editor = null;
        this.form = null;
        this.submitHandler = null;
    }
}
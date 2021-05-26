import {registerPlugin} from "@wordpress/plugins";
import {PluginSidebar, PluginSidebarMoreMenuItem} from "@wordpress/edit-post";
import {__} from "@wordpress/i18n";
import {PanelBody, TextareaControl, ColorPicker} from "@wordpress/components";
import { withSelect, withDispatch } from "@wordpress/data";


let PluginMetaFields = (props) => {
    return (
        <div>
            <PanelBody
                title={__('Панель метаполя', 'kvasov')}
                icon="admin-post"
                intalOpen={ true }>

                <TextareaControl
                    value={props.text_metafield}
                    label={__('Текст метаполя', 'kvasov')}
                    onChange={(value) => props.onMetaFieldChange(value)}
                />
                <ColorPicker
                    color={props.text_metafield}
                    label={__("Мета цвет", "kvasov")}
                    onChangeComplete={(colour) => props.onMetaFieldChange(colour.hex)}
                />
            </PanelBody>
        </div>
    );
}

PluginMetaFields = withSelect(
    (select) => {
        return {
            text_metafield: select('core/editor').getEditedPostAttribute('meta')['_kvasov_text_metafield']
        }
    }
)(PluginMetaFields);

PluginMetaFields = withDispatch(
    (dispatch) => {
        return {
            onMetaFieldChange: (value) => {
                dispatch('core/editor').editPost({meta: {_kvasov_text_metafield: value}})
            }
        }
    }
)(PluginMetaFields);

registerPlugin('kvasov-sidebar', {
    icon: 'smiley',
    render: () => {
        return (
            <div>

                <PluginSidebarMoreMenuItem target="kvasov-sidebar">
                    {__('Мета параметры', 'kvasov')}
                </PluginSidebarMoreMenuItem>

                <PluginSidebar name="kvasov-sidebar" title={__('Мета параметры', 'kvasov')}>
                    <PluginMetaFields />
                </PluginSidebar>
            </div>
        )
    }
});
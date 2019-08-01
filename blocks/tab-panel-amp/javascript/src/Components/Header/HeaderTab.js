import React from 'react';
import {RichText} from "@wordpress/editor";
import {Button} from "@wordpress/components"

export default class HeaderTab extends React.Component
{
    removeRow(e) {
        e.stopPropagation();
        let tabs = this.props.attributes.tabs.filter(el => el.hash !== this.props.item.hash);
        this.props.setAttributes({
            tabs: tabs,
            edit: tabs.length - 1
        });
    }

    setEditMode() {
        this.props.setAttributes({
            edit: this.props.index
        });
    }

    changeTitle(value) {
        this.props.setAttributes({
            tabs: this.props.attributes.tabs.map(el => {
                if (el.hash === this.props.item.hash) {
                    el.title = value;
                }

                return el;
            })
        })
    }

    render() {
        let editMode = this.props.attributes.edit === this.props.index;
        return (
            <div
                onClick={() => this.setEditMode()}
                className={editMode && 'active'}
            >
                {editMode ?
                    (
                        <RichText
                            value={this.props.item.title}
                            placeholder={'Tab title goes here...'}
                            onChange={val => this.changeTitle(val)}
                        />
                    ) : (
                        this.props.item.title || <span>Tab title goes here...</span>
                    )}
                <Button onClick={(e) => this.removeRow(e)}>✕</Button>
            </div>
        )
    }
}
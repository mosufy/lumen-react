/**
 * MyTodoItems
 *
 * @date 23/10/2016
 * @author Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

import React from 'react';

export default class MyTodoItems extends React.Component {
  render() {
    if (this.props.items.length == 0) {
      return (
        <div>
          No items in your ToDo.<br/>
          Start by creating a new ToDo.
        </div>
      );
    }

    return (
      <ul>
        {this.props.items.map(item => {
          if (this.props.visibilityFilter == 'SHOW_ACTIVE' && item.completed) {
            return;
          }

          if (this.props.visibilityFilter == 'SHOW_COMPLETED' && !item.completed) {
            return;
          }

          var itemText = item.text;
          var defaultChecked;

          if (item.completed) {
            itemText = (
              <del>{item.text}</del>
            );
            defaultChecked = 'defaultChecked';
          }

          return (
            <div className="checkbox" key={item.id}>
              <label>
                <input id={item.id} type="checkbox" value={item.id} onClick={this.props.toggleCompleted} defaultChecked={defaultChecked}/>{itemText}
              </label>
            </div>
          );
        })}
      </ul>
    );
  }
}
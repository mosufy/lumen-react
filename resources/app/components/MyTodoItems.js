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
    var toggleCompleted = this.props.toggleCompleted;
    return (
      <ul>
        {this.props.items.map(item => {
          var itemText = item.text;
          if (item.completed) {
            itemText = (
              <del>{item.text}</del>
            );
          }
          return (
            <div className="checkbox" key={item.id}>
              <label><input id={item.id} type="checkbox" value="" onClick={toggleCompleted}/>{itemText}</label>
            </div>
          );
        })}
      </ul>
    );
  }
}
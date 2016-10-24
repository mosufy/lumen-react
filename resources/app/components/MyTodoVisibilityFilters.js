/**
 * MyTodoVisibilityFilters
 *
 * @date 24/10/2016
 * @author Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

import React from 'react';
import MyTodoVisibilityFilterLink from './MyTodoVisibilityFilterLink';

export default class MyTodoVisibilityFilters extends React.Component {
  render() {
    return (
      <div className="btn-group" role="group">
        <MyTodoVisibilityFilterLink filter="SHOW_ALL" {...this.props}>Show All</MyTodoVisibilityFilterLink>
        <MyTodoVisibilityFilterLink filter="SHOW_ACTIVE" {...this.props}>Show Active</MyTodoVisibilityFilterLink>
        <MyTodoVisibilityFilterLink filter="SHOW_COMPLETED" {...this.props}>Show Completed</MyTodoVisibilityFilterLink>
      </div>
    );
  }
}
/**
 * MyTodoVisibilityFilters
 *
 * @date 24/10/2016
 * @author Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

import React from 'react';
import MyTodoVisibilityFilterLink from './MyTodoVisibilityFilterLink';

const MyTodoVisibilityFilters = (props) => {
  return (
    <div className="btn-group" role="group">
      <MyTodoVisibilityFilterLink filter="SHOW_ALL" {...props}>Show All</MyTodoVisibilityFilterLink>
      <MyTodoVisibilityFilterLink filter="SHOW_ACTIVE" {...props}>Show Active</MyTodoVisibilityFilterLink>
      <MyTodoVisibilityFilterLink filter="SHOW_COMPLETED" {...props}>Show Completed</MyTodoVisibilityFilterLink>
    </div>
  );
};

export default MyTodoVisibilityFilters;